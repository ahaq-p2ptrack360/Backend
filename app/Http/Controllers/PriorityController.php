<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Concerns\ScopesTenantCompanyData;

class PriorityController extends Controller
{
    use ScopesTenantCompanyData;

    public function index()
    {
        $query = DB::table('priority as s')->leftJoin('company as c', 's.company_id', '=', 'c.id')
            ->selectRaw('s.*, IFNULL(c.name, "System") as company')->where('s.active', 1);
        $priorities = $this->scopeVisibleCompanyData($query, 's.company_id')->get();
        return response()->json($priorities);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'active' => 'required|boolean', 'sla' => 'nullable', 'company_id' => 'nullable|integer']);
        DB::insert('INSERT INTO priority (company_id, title, active, sla) VALUES (?, ?, ?, ?)', [$this->tenantCompanyId($data['company_id'] ?? 0), $data['title'], $data['active'], $data['sla'] ?? null]);
        return response()->json(['message' => 'Priority created successfully']);
    }

    public function show($id)
    {
        $priority = $this->scopeVisibleCompanyData(DB::table('priority'))
            ->where('id', $id)->get();
        return response()->json($priority);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'active' => 'required|boolean', 'sla' => 'nullable', 'company_id' => 'nullable|integer']);
        $query = $this->scopeWritableCompanyData(DB::table('priority'))->where('id', $id);
        $existing = $query->first();
        if (!$existing) {
            return response()->json(['message' => 'Priority not found'], 404);
        }
        $this->scopeWritableCompanyData(DB::table('priority'))->where('id', $id)->update([
            'company_id' => $this->tenantCompanyId($data['company_id'] ?? $existing->company_id),
            'title' => $data['title'],
            'active' => $data['active'],
            'sla' => $data['sla'] ?? null,
        ]);
        return response()->json(['message' => 'Priority updated successfully']);
    }


    public function companywise($id)
    {
        $query = DB::table('priority as s')->leftJoin('company as c', 's.company_id', '=', 'c.id')
            ->selectRaw('s.*, IFNULL(c.name, "System") as company')
            ->where('s.company_id', $id)->where('s.active', 1);
        $status = $this->scopeVisibleCompanyData($query, 's.company_id')->get();
        return response()->json($status);
    }

    public function destroy($id)
    {
        $query = $this->scopeWritableCompanyData(DB::table('priority'))->where('id', $id);
        if (!$query->exists()) {
            return response()->json(['message' => 'Priority not found'], 404);
        }
        $query->delete();
        return response()->json(['message' => 'Priority deleted successfully']);
    }
    
    public function updateprioritystatus(Request $request)
    {
        $data = $request->validate(['active' => 'required|boolean', 'id' => 'required|integer']);
        $query = $this->scopeWritableCompanyData(DB::table('priority'))->where('id', $data['id']);
        if (!$query->exists()) {
            return response()->json(['message' => 'Priority not found'], 404);
        }
        $query->update(['active' => $data['active']]);
        return response()->json(['message' => 'Priority status updated successfully']);
    }
}
