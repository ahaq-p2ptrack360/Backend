<?php

namespace App\Imports;

use App\Models\group_des;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class group_designation implements ToModel, WithHeadingRow
{
    protected $companyCache = [];
    protected $businessUnitsCache = [];
    protected $groupsCache = [];
    protected $designationsCache = [];
    
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
            // Company doesn't exist, you might want to create it or skip
            return null;
        }
        $companyId = $company->id;

        // Get business unit
        $buId = $row["bu"] ?? null;
        if (!$buId) {
            return null; // Skip if no business unit
        }

        $businessUnit = $this->getBusinessUnit($companyId, $buId);
        if (!$businessUnit) {
            // Business unit doesn't exist, skip or create
            return null;
        }
        $buId = $businessUnit->id;

        // Get or create group
        $groupName = $row["group"] ?? null;
        if (!$groupName) {
            return null; // Skip if no group
        }

        $group = $this->getOrCreateGroup($companyId, $buId, $groupName, $row["created_by"] ?? null);
        if (!$group) {
            return null;
        }
        $groupId = $group->id;

        // Get or create designation
        $designationName = $row["designation"] ?? null;
        if (!$designationName) {
            return null; // Skip if no designation
        }

        $designation = $this->getOrCreateDesignation($companyId, $designationName);
        if (!$designation) {
            return null;
        }
        $designationId = $designation->id;

        return new group_des([
            'bu_id' => $buId,
            'group_id' => $groupId,
            'designation_id' => $designationId
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

    private function getBusinessUnit($companyId, $buId)
    {
        $key = "{$companyId}_{$buId}";
        if (!isset($this->businessUnitsCache[$key])) {
            $businessUnit = DB::table('business_units')
                ->where('company_id', $companyId)
                ->where('id', $buId)
                ->first();
            $this->businessUnitsCache[$key] = $businessUnit;
        }
        return $this->businessUnitsCache[$key];
    }

    private function getOrCreateGroup($companyId, $buId, $groupName, $createdBy = null)
    {
        $key = "{$companyId}_{$buId}_{$groupName}";
        if (!isset($this->groupsCache[$key])) {
            $group = DB::table('bu_group')
                ->where('company_id', $companyId)
                ->where('bu_id', $buId)
                ->where('title', $groupName)
                ->first();
            
            if (!$group) {
                // Create the specific group from the Excel
                $groupId = DB::table('bu_group')->insertGetId([
                    'title' => $groupName,
                    'bu_id' => $buId,
                    'company_id' => $companyId,
                    'created_by' => $createdBy
                ]);
                
                $group = (object) [
                    'id' => $groupId,
                    'title' => $groupName,
                    'bu_id' => $buId,
                    'company_id' => $companyId
                ];
            }
            
            $this->groupsCache[$key] = $group;
        }
        return $this->groupsCache[$key];
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
}