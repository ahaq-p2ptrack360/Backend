<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Concerns\ScopesTenantCompanyData;

class ImpactController extends Controller
{
    use ScopesTenantCompanyData;

    public function index()
    {
        $query = DB::table('impacts as s')->leftJoin('company as c', 's.company_id', '=', 'c.id')
            ->selectRaw('s.*, IFNULL(c.name, "System") as company')->where('s.active', 1);
        $impacts = $this->scopeVisibleCompanyData($query, 's.company_id')->get();
        return response()->json($impacts);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'active' => 'required|boolean', 'company_id' => 'nullable|integer']);
        DB::insert('INSERT INTO impacts (company_id, title, active) VALUES (?, ?, ?)', [$this->tenantCompanyId($data['company_id'] ?? 0), $data['title'], $data['active']]);
        return response()->json(['message' => 'Impact created successfully']);
    }

    public function show($id)
    {
        $impact = $this->scopeVisibleCompanyData(DB::table('impacts'))->where('id', $id)->get();
        return response()->json($impact);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'active' => 'required|boolean', 'company_id' => 'nullable|integer']);
        $query = $this->scopeWritableCompanyData(DB::table('impacts'))->where('id', $id);
        $existing = $query->first();
        if (!$existing) {
            return response()->json(['message' => 'Impact not found'], 404);
        }
        $this->scopeWritableCompanyData(DB::table('impacts'))->where('id', $id)->update([
            'company_id' => $this->tenantCompanyId($data['company_id'] ?? $existing->company_id),
            'title' => $data['title'],
            'active' => $data['active'],
        ]);
        return response()->json(['message' => 'Impact updated successfully']);
    }


    public function companywise($id)
    {
        $query = DB::table('impacts as s')->leftJoin('company as c', 's.company_id', '=', 'c.id')
            ->selectRaw('s.*, IFNULL(c.name, "System") as company')
            ->where('s.company_id', $id)->where('s.active', 1);
        $status = $this->scopeVisibleCompanyData($query, 's.company_id')->get();
        return response()->json($status);
    }


    public function destroy($id)
    {
        $query = $this->scopeWritableCompanyData(DB::table('impacts'))->where('id', $id);
        if (!$query->exists()) {
            return response()->json(['message' => 'Impact not found'], 404);
        }
        $query->delete();
        return response()->json(['message' => 'Impact deleted successfully']);
    }
    public function updateimpactstatus(Request $request)
    {
        $data = $request->validate(['active' => 'required|boolean', 'id' => 'required|integer']);
        $query = $this->scopeWritableCompanyData(DB::table('impacts'))->where('id', $data['id']);
        if (!$query->exists()) {
            return response()->json(['message' => 'Impact not found'], 404);
        }
        $query->update(['active' => $data['active']]);
        return response()->json(['message' => 'Type status updated successfully']);
    }


    
}
