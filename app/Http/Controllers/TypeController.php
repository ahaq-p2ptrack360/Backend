<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Concerns\ScopesTenantCompanyData;

class TypeController extends Controller
{
    use ScopesTenantCompanyData;

    public function index()
    {
        $query = DB::table('types as t1')->leftJoin('types as t2', 't1.parent_id', '=', 't2.id')
            ->leftJoin('company as c', 't1.company_id', '=', 'c.id')
            ->selectRaw('CASE WHEN t1.company_id = "0" THEN "System" ELSE c.name END as company, t1.id, t1.title, t1.active, t1.created_at, t1.parent_id, t2.title as parent')
            ->where('t1.active', 1);
        $types = $this->scopeVisibleCompanyData($query, 't1.company_id')->get();
        return response()->json($types);
    }


    public function companywise($id)
    {
        $query = DB::table('types as t1')->leftJoin('types as t2', 't1.parent_id', '=', 't2.id')
            ->leftJoin('company as c', 't1.company_id', '=', 'c.id')
            ->selectRaw('CASE WHEN t1.company_id = "0" THEN "System" ELSE c.name END as company, t1.id, t1.active, t1.title, t1.parent_id, t1.created_at, t2.title as parent')
            ->where('c.id', $id)->where('t1.active', 1);
        $type = $this->scopeVisibleCompanyData($query, 't1.company_id')->get();
        return response()->json($type);
    }


    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'parent_id' => 'nullable|integer', 'active' => 'required|boolean', 'company_id' => 'nullable|integer']);
        if (!empty($data['parent_id']) && !$this->scopeVisibleCompanyData(DB::table('types'))
            ->where('id', $data['parent_id'])->exists()) {
            return response()->json(['message' => 'Parent type not found'], 422);
        }
        DB::insert('INSERT INTO types (company_id, title, parent_id, active) VALUES (?, ?, ?, ?)', [
            $this->tenantCompanyId($data['company_id'] ?? 0),
            $data['title'],
            $data['parent_id'],
            $data['active']
        ]);
        return response()->json(['message' => 'Type created successfully']);
    }

    public function show($id)
    {
        $type = $this->scopeVisibleCompanyData(DB::table('types'))
            ->where('id', $id)->get();
        return response()->json($type);
    }

    public function parent($id)
    {
        $type = $this->scopeVisibleCompanyData(DB::table('types'))
            ->where('parent_id', $id)->get();
        return response()->json($type);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'parent_id' => 'nullable|integer', 'active' => 'required|boolean', 'company_id' => 'nullable|integer']);
        if (!empty($data['parent_id']) && !$this->scopeVisibleCompanyData(DB::table('types'))
            ->where('id', $data['parent_id'])->exists()) {
            return response()->json(['message' => 'Parent type not found'], 422);
        }
        $query = $this->scopeWritableCompanyData(DB::table('types'))->where('id', $id);
        $existing = $query->first();
        if (!$existing) {
            return response()->json(['message' => 'Type not found'], 404);
        }
        $this->scopeWritableCompanyData(DB::table('types'))->where('id', $id)->update([
            'company_id' => $this->tenantCompanyId($data['company_id'] ?? $existing->company_id),
            'title' => $data['title'],
            'parent_id' => $data['parent_id'] ?? null,
            'active' => $data['active'],
        ]);
        return response()->json(['message' => 'Type updated successfully']);
    }

    public function destroy($id)
    {
        $query = $this->scopeWritableCompanyData(DB::table('types'))->where('id', $id);
        if (!$query->exists()) {
            return response()->json(['message' => 'Type not found'], 404);
        }
        $query->delete();
        return response()->json(['message' => 'Type deleted successfully']);
    }

    public function updatetypestatus(Request $request)
    {
        $data = $request->validate(['active' => 'required|boolean', 'id' => 'required|integer']);
        $query = $this->scopeWritableCompanyData(DB::table('types'))->where('id', $data['id']);
        if (!$query->exists()) {
            return response()->json(['message' => 'Type not found'], 404);
        }
        $query->update(['active' => $data['active']]);
        return response()->json(['message' => 'Type status updated successfully']);
    }
}
