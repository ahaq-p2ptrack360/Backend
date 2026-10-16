<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Concerns\ScopesTenantCompanyData;

class DesignationController extends Controller
{
    use ScopesTenantCompanyData;

    public function index()
    {
        $query = DB::table('designations as s')->leftJoin('company as c', 's.company_id', '=', 'c.id')
            ->selectRaw('s.*, IFNULL(c.name, "System") as company')->where('s.active', 1);
        $designations = $this->scopeVisibleCompanyData($query, 's.company_id')->get();
        return response()->json($designations);
    }
    public function designation($id){
        $query = DB::table('users as u')->join('designations as d', 'u.designation_id', '=', 'd.id')
            ->where('u.designation_id', $id);
        if ($this->tenantCompanyId() !== null && (int) $this->tenantCompanyId() !== 0) {
            $query->where('u.company_id', $this->tenantCompanyId())
                ->where('d.company_id', $this->tenantCompanyId());
        }
        $dname = $query->distinct()->get(['d.title']);
        return response()->json($dname);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'active' => 'required|boolean', 'company_id' => 'nullable|integer']);

        DB::insert('INSERT INTO designations (company_id, title, active) VALUES (?, ?, ?)',
            [$this->tenantCompanyId($data['company_id'] ?? 0), $data['title'], $data['active']]);

        return response()->json(['message' => 'Designation created successfully']);
    }

    public function show($id)
    {
        $designation = $this->scopeVisibleCompanyData(DB::table('designations'))->where('id', $id)->get();
        return response()->json($designation);
    }

    public function companywise($id)
    {
        $query = DB::table('designations as s')->leftJoin('company as c', 's.company_id', '=', 'c.id')
            ->selectRaw('s.*, IFNULL(c.name, "System") as company')
            ->where('s.company_id', $id)->where('s.active', 1);
        $designations = $this->scopeVisibleCompanyData($query, 's.company_id')->get();
        return response()->json($designations);
    }
    public function update(Request $request, $id)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'active' => 'required|boolean', 'company_id' => 'nullable|integer']);
        $query = $this->scopeWritableCompanyData(DB::table('designations'))->where('id', $id);
        $existing = $query->first();
        if (!$existing) {
            return response()->json(['message' => 'Designation not found'], 404);
        }
        $this->scopeWritableCompanyData(DB::table('designations'))->where('id', $id)->update([
            'company_id' => $this->tenantCompanyId($data['company_id'] ?? $existing->company_id),
            'title' => $data['title'],
            'active' => $data['active'],
        ]);

        return response()->json(['message' => 'Designation updated successfully']);
    }

    public function destroy($id)
    {
        $query = $this->scopeWritableCompanyData(DB::table('designations'))->where('id', $id);
        if (!$query->exists()) {
            return response()->json(['message' => 'Designation not found'], 404);
        }
        $query->delete();
        return response()->json(['message' => 'Designation deleted successfully']);
    }
    public function updatedesigstatus(Request $request)
    {
        $data = $request->validate(['active' => 'required|boolean', 'id' => 'required|integer']);
        $query = $this->scopeWritableCompanyData(DB::table('designations'))->where('id', $data['id']);
        if (!$query->exists()) {
            return response()->json(['message' => 'Designation not found'], 404);
        }
        $query->update(['active' => $data['active']]);
        return response()->json(['message' => 'Type status updated successfully']);
    }
}

