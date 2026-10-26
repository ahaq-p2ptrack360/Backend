<?php

namespace App\Imports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\newuser;

class UserImport implements ToModel, WithHeadingRow
{
    protected $companyCache = [];
    protected $businessUnitsCache = [];
    protected $designationsCache = [];
    protected $rolesCache = [];
    
    public function model(array $row)
    {
        
        // Convert 'NULL' strings to null
        foreach ($row as &$value) {
            if ($value === 'NULL') {
                $value = null;
            }
        }

        // Get company
        $companyName = $row["company"] ?? null;
        if (!$companyName) {
            return null; // Skip if no company
        }

        $company = $this->getCompany($companyName);
        if (!$company) {
            // Company doesn't exist, skip or create
            return null;
        }
        $companyId = $company->id;

        // Get business unit
        $buName = $row["business_units"] ?? null;
        $businessUnit = null;
        if ($buName) {
            $businessUnit = $this->getBusinessUnit($companyId, $buName);
        }
        $buId = $businessUnit ? $businessUnit->id : 0;

        // Get or create designation
        $designationName = $row["designation"] ?? null;
        $designationId = null;
        if ($designationName) {
            $designation = $this->getOrCreateDesignation($companyId, $designationName);
            $designationId = $designation ? $designation->id : null;
        }

        // Get or create role
        $roleName = $row["role"] ?? null;
        $roleId = null;
        if ($roleName) {
            $role = $this->getOrCreateRole($companyId, $roleName);
            $roleId = $role ? $role->id : null;
        }

        // Generate password and username
        $password = Str::random(8);
        $hashedPassword = Hash::make($password);
        
        // Process email - use provided email or generate one
        $userEmail = $row["email"] ?? null;
        if (!$userEmail || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            // Generate email if not provided or invalid
            $firstName = $row["first_name"] ?? '';
            $lastName = $row["last_name"] ?? '';
            $userEmail = strtolower($firstName . '.' . $lastName . '.' . mt_rand(100, 9999) . '@' . 
                strtolower(str_replace([' ', '.', 'Inc', 'Ltd', 'Corp', 'LLC', 'Co'], '', $companyName)) . '.com');
        }
        
        // Generate username for login
        $firstName = $row["first_name"] ?? '';
        $lastName = $row["last_name"] ?? '';
        $userName = strtolower($firstName . '.' . $lastName . '.' . mt_rand(100, 9999) . '@gmail.com');

        // Send email with credentials
        $this->sendCredentialsEmail($userEmail, $userName, $password);

        // Get full name
        $fullName = trim(($row["first_name"] ?? '') . ' ' . ($row["last_name"] ?? ''));

        return new newuser([
            'first_name' => $row["first_name"] ?? null,
            'last_name' => $row["last_name"] ?? null,
            'company_id' => $companyId,
            'bu_id' => $buId,
            'designation_id' => $designationId,
            'name' => $fullName, // Assuming this is the full name field
            'email' => $userName, // Login username/email
            'password' => $hashedPassword,
            'two_factor_secret' => $password, // Storing plain password for reference (not recommended for production)
            'about' => $userEmail, // Original email in about field
            'photo_url' => null,
            'role' => $roleId,
            'type' => $row["type"] ?? null
        ]);
    }

    private function getCompany($companyName)
    {
        $key = $companyName;
        if (!isset($this->companyCache[$key])) {
            $company = DB::table('company')
                ->where('name', $companyName)
                ->first();
            $this->companyCache[$key] = $company;
        }
        return $this->companyCache[$key];
    }

    private function getBusinessUnit($companyId, $buName)
    {
        $key = "{$companyId}_{$buName}";
        if (!isset($this->businessUnitsCache[$key])) {
            $businessUnit = DB::table('business_units')
                ->where('company_id', $companyId)
                ->where('name', $buName)
                ->first();
            $this->businessUnitsCache[$key] = $businessUnit;
        }
        return $this->businessUnitsCache[$key];
    }

    private function getOrCreateDesignation($companyId, $designationName)
    {
        $key = "{$companyId}_{$designationName}";
        if (!isset($this->designationsCache[$key])) {
            $designation = DB::table('designations')
                ->where('company_id', $companyId)
                ->where('title', $designationName)
                ->first();
            
            if (!$designation) {
                $designationId = DB::table('designations')->insertGetId([
                    'company_id' => $companyId,
                    'title' => $designationName,
                    'active' => 1
                ]);
                
                $designation = (object) [
                    'id' => $designationId,
                    'title' => $designationName,
                    'company_id' => $companyId
                ];
            }
            
            $this->designationsCache[$key] = $designation;
        }
        return $this->designationsCache[$key];
    }

    private function getOrCreateRole($companyId, $roleName)
    {
        $key = "{$companyId}_{$roleName}";
        if (!isset($this->rolesCache[$key])) {
            $role = DB::table('roles')
                ->where('company_id', $companyId)
                ->where('name', $roleName)
                ->first();
            
            if (!$role) {
                // Assuming roles table structure - adjust columns as needed
                $roleId = DB::table('roles')->insertGetId([
                    'company_id' => $companyId,
                    'name' => $roleName,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                $role = (object) [
                    'id' => $roleId,
                    'name' => $roleName,
                    'company_id' => $companyId
                ];
            }
            
            $this->rolesCache[$key] = $role;
        }
        return $this->rolesCache[$key];
    }

    private function sendCredentialsEmail($toEmail, $username, $password)
    {
        try {
            $data = [
                'email' => $username,
                'password' => $password,
            ];
            
            $mailContent = view('mail3', $data)->render();

            Mail::send([], [], function ($message) use ($mailContent, $toEmail) {
                $message->to($toEmail, 'User Login Credentials')
                    ->subject('User Login Credentials')
                    ->setBody($mailContent, 'text/html');
            });
        } catch (\Exception $e) {
            // Log error but don't stop import
            \Log::error('Failed to send email: ' . $e->getMessage());
        }
    }
}