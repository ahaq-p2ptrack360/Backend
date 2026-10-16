<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Concerns\ScopesTenantCompanyData;

class StatusController extends Controller
{
    use ScopesTenantCompanyData;

    public function index()
    {
        $query = DB::table('status as s')->leftJoin('company as c', 's.company_id', '=', 'c.id')
            ->selectRaw('s.*, IFNULL(c.name, "System") as company')->where('s.active', 1);
        $statuses = $this->scopeVisibleCompanyData($query, 's.company_id')->get();
        return response()->json($statuses);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'active' => 'required|boolean', 'company_id' => 'nullable|integer']);
        DB::insert('INSERT INTO status (company_id, title, active) VALUES (?, ?, ?)', [
            $this->tenantCompanyId($data['company_id'] ?? 0),
            $data['title'],
            $data['active']
            
        ]);
        return response()->json(['message' => 'Status created successfully']);
    }

    public function show($id)
    {
        $status = $this->scopeVisibleCompanyData(DB::table('status'))
            ->where('id', $id)->get();
        return response()->json($status);
    }


    public function companywise($id)
    {
        $query = DB::table('status as s')->leftJoin('company as c', 's.company_id', '=', 'c.id')
            ->selectRaw('s.*, IFNULL(c.name, "System") as company')
            ->where('s.company_id', $id)->where('s.active', 1);
        $status = $this->scopeVisibleCompanyData($query, 's.company_id')->get();
        return response()->json($status);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'active' => 'required|boolean', 'company_id' => 'nullable|integer']);
        $query = $this->scopeWritableCompanyData(DB::table('status'))->where('id', $id);
        $existing = $query->first();
        if (!$existing) {
            return response()->json(['message' => 'Status not found'], 404);
        }
        $this->scopeWritableCompanyData(DB::table('status'))->where('id', $id)->update([
            'company_id' => $this->tenantCompanyId($data['company_id'] ?? $existing->company_id),
            'title' => $data['title'],
            'active' => $data['active'],
            'updated_at' => now(),
        ]);
        return response()->json(['message' => 'Status updated successfully']);
    }

    public function destroy($id)
    {
        $query = $this->scopeWritableCompanyData(DB::table('status'))->where('id', $id);
        if (!$query->exists()) {
            return response()->json(['message' => 'Status not found'], 404);
        }
        $query->delete();
        return response()->json(['message' => 'Status deleted successfully']);
    }

    public function updateactivestatus(Request $request)
    {
        $data = $request->validate(['active' => 'required|boolean', 'id' => 'required|integer']);
        $query = $this->scopeWritableCompanyData(DB::table('status'))->where('id', $data['id']);
        if (!$query->exists()) {
            return response()->json(['message' => 'Status not found'], 404);
        }
        $query->update(['active' => $data['active']]);
        return response()->json(['message' => 'Type status updated successfully']);
    }
}
