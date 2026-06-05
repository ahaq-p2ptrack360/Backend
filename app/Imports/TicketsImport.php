<?php

namespace App\Imports;

use App\Models\Priority;
use App\Models\Tickets_new;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TicketsImport implements ToModel, WithHeadingRow
{
    protected $company;
    protected $users;
    protected $businessUnits;
    protected $types;
    protected $priorities;
    protected $impacts;
    protected $statuses;
    
    public function __construct()
    {
        // Fetch all data once
        $this->company = DB::table('company')->get();
        $this->users = DB::table('users')->get();
        $this->businessUnits = DB::table('business_units')->get();
        $this->types = DB::table('types')->get();
        $this->priorities = DB::table('priority')->get();
        $this->impacts = DB::table('impacts')->get();
        $this->statuses = DB::table('status')->get();
    }
    
    private function findCompany($companyName)
    {
        return $this->company
            ->where('name', $companyName)
            ->first();
    }
    
    private function findUser($companyId, $userName)
    {
        return $this->users
            ->where('company_id', $companyId)
            ->where('name', $userName)
            ->first();
    }
    
    private function findBusinessUnit($companyId, $businessUnitName)
    {
        return $this->businessUnits
            ->where('company_id', $companyId)
            ->where('name', $businessUnitName)
            ->first();
    }
    
    private function findPriority($companyId, $priorityTitle)
    {
        return $this->priorities
            ->where('company_id', $companyId)
            ->where('title', $priorityTitle)
            ->first();
    }
    
    private function findImpact($companyId, $impactTitle)
    {
        return $this->impacts
            ->where('company_id', $companyId)
            ->where('title', $impactTitle)
            ->first();
    }
    
    private function findStatus($companyId, $statusTitle)
    {
        return $this->statuses
            ->where('company_id', $companyId)
            ->where('title', $statusTitle)
            ->first();
    }
    
    private function findType($companyId, $typeTitle)
    {
        return $this->types
            ->where('company_id', $companyId)
            ->where('title', $typeTitle)
            ->first();
    }

    public function model(array $row)
    {
        // Convert serialized dates
   

        $completed_date = null;
        if (!empty($row['completed_date'])) {
            $date = Carbon::createFromFormat('Y-m-d', '1900-01-01')
                ->addDays($row['completed_date'] - 2);
            $completed_date = $date->format('Y-m-d');
        }
        
        $due_date = null;
        if (!empty($row['due_date'])) {
            $date = Carbon::createFromFormat('Y-m-d', '1900-01-01')
                ->addDays($row['due_date'] - 2);
            $due_date = $date->format('Y-m-d');
        }

        // First, get company from the row (assuming the Excel has a 'company' column with company name)
        $companyName = $row["company"] ?? null;
        $companyRecord = $this->findCompany($companyName);

        // Check if company exists
        if (!$companyRecord) {
            // Handle missing company - you can throw an exception, skip the row, or create the company
            // For now, let's skip this row
            return null;
        }

        $companyId = $companyRecord->id;
        // Find users from the already fetched users collection
        $assign_to = $this->findUser($companyId, $row["assigned_to"] ?? null);
        $reported_by = $this->findUser($companyId, $row["reported_by"] ?? null);
        $completed_by = $this->findUser($companyId, $row["completed_by"] ?? null);
        $created_by = $this->findUser($companyId, $row["created_by"] ?? null);
        
        // Find other entities
        $business = $this->findBusinessUnit($companyId, $row["business_unit"] ?? null);
        $priority = $this->findPriority($companyId, $row["priority"] ?? null);
        $impact = $this->findImpact($companyId, $row["impact"] ?? null);
        $status = $this->findStatus($companyId, $row["status"] ?? null);
        $type = $this->findType($companyId, $row["sub_type"] ?? null);

        // Set IDs or create new records if not found
        $assign_to_id = $assign_to->id ?? null;
        $reported_by_id = $reported_by->id ?? ($created_by->id ?? null);
        $completed_by_id = $completed_by->id ?? null;
        $created_by_id = $created_by->id ?? null;
        $bu_id = $business->id ?? $row["business_unit"] ?? null;
        
        // Create priority if not found
        if (!$priority) {
            $priority_id = DB::table('priority')->insertGetId([
                'company_id' => $companyId,
                'title' => $row["priority"],
                'active' => 1,
                'sla' => 1
            ]);
            // Add to collection for future rows
            $this->priorities->push((object)[
                'id' => $priority_id,
                'company_id' => $companyId,
                'title' => $row["priority"]
            ]);
        } else {
            $priority_id = $priority->id;
        }
        
        // Create impact if not found
        if (!$impact) {
            $impact_id = DB::table('impacts')->insertGetId([
                'company_id' => $companyId,
                'title' => $row["impact"],
                'active' => 1
            ]);
            $this->impacts->push((object)[
                'id' => $impact_id,
                'company_id' => $companyId,
                'title' => $row["impact"]
            ]);
        } else {
            $impact_id = $impact->id;
        }
        
        // Create status if not found
        if (!$status) {
            $status_id = DB::table('status')->insertGetId([
                'company_id' => $companyId,
                'title' => $row["status"],
                'active' => 1
            ]);
            $this->statuses->push((object)[
                'id' => $status_id,
                'company_id' => $companyId,
                'title' => $row["status"]
            ]);
        } else {
            $status_id = $status->id;
        }
        
        // Create type if not found
        if (!$type) {
            $type_id = DB::table('types')->insertGetId([
                'company_id' => $companyId,
                'title' => $row["sub_type"]
            ]);
            $this->types->push((object)[
                'id' => $type_id,
                'company_id' => $companyId,
                'title' => $row["sub_type"]
            ]);
        } else {
            $type_id = $type->id;
        }

        // Convert 'NULL' strings to null
        foreach ($row as &$value) {
            if ($value === 'NULL') {
                $value = null;
            }
        }

        return new Tickets_new([
            'title' => $row["title"] ?? null,
            'description' => $row["description"] ?? null,
            'completed_date' => $completed_date,
            'due_date' => $due_date,
            'company_id' => $companyId,
            'completed_by' => $completed_by_id,
            'business_unit_id' => $bu_id,
            'reported_by' => $reported_by_id,
            'assigned_to' => $assign_to_id,
            'mode_of_complaint' => $row["mode_of_complaint"] ?? null,
            'sub_type_id' => $type_id,
            'priority_id' => $priority_id,
            'impact_id' => $impact_id,
            'status_id' => $status_id,
            'file' => $row["file"] ?? null,
            'store_contact' => $row["store_contact"] ?? null,
            'created_by' => $created_by_id, // Changed from $created_by to $created_by_id
        ]);
    }
}