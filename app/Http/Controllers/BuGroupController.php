<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Concerns\ScopesTenantCompanyData;

class BuGroupController extends Controller
{
    use ScopesTenantCompanyData;

    public function index()
    {
        $query = DB::table('bu_group as s')->leftJoin('company as c', 's.company_id', '=', 'c.id')
            ->join('business_units as b', 's.bu_id', '=', 'b.id')
            ->selectRaw('s.*, IFNULL(c.name, "System") as company, b.name');
        $buGroups = $this->scopeVisibleCompanyData($query, 's.company_id')->get();
        return response()->json($buGroups);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'bu_id' => 'required|integer', 'company_id' => 'nullable|integer']);
        $companyId = $this->tenantCompanyId($data['company_id'] ?? 0);
        if (!$this->ownedBusinessUnit($data['bu_id'], $companyId)) {
            return response()->json(['message' => 'Business unit not found'], 404);
        }

        $insertedId = DB::table('bu_group')->insertGetId([
            'title' => $data['title'],
            'bu_id' => $data['bu_id'],
            'company_id' => $companyId,
            'created_by' => auth()->id(),
        ]);

        return response()->json(['message' => 'Data inserted successfully', 'inserted_id' => $insertedId]);
    }
    public function show($id)
    {
        $buGroup = $this->scopeVisibleCompanyData(DB::table('bu_group'))->where('id', $id)->get();
        return response()->json($buGroup);
    }
    public function bu_groupdropdown($id)
    {
        $companyId = $this->tenantCompanyId();
        $bu_groupdropdown = DB::table('bu_group')->where('bu_id', $id)
            ->when($companyId !== null && (int) $companyId !== 0, function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })->get();
        return response()->json($bu_groupdropdown);
    }

    public function group_designation(Request $request)
    {
        $data = $request->validate(['bu_id' => 'required|integer', 'group_id' => 'required|integer', 'designation_id' => 'required|integer']);
        $companyId = $this->tenantCompanyId();
        $group = $this->scopeWritableCompanyData(DB::table('bu_group'))->where('id', $data['group_id'])->first();
        if (!$group || (int) $group->bu_id !== (int) $data['bu_id'] || !$this->ownedBusinessUnit($data['bu_id'], $companyId)) {
            return response()->json(['message' => 'Group or business unit not found'], 404);
        }
        if (!DB::table('designations')->where('id', $data['designation_id'])->where('company_id', $group->company_id)->exists()) {
            return response()->json(['message' => 'Designation not found'], 404);
        }

        DB::insert('INSERT INTO `group_designation`( `bu_id`, `group_id`, `designation_id`) VALUES (?,?,?)',
            [$data['bu_id'], $data['group_id'], $data['designation_id']]);
            $insertedId = DB::getPdo()->lastInsertId();
            return response()->json(['message'=>'Designation Assigned Successfully','inserted_id'=>$insertedId]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'bu_id' => 'required|integer', 'company_id' => 'nullable|integer']);
        $query = $this->scopeWritableCompanyData(DB::table('bu_group'))->where('id', $id);
        $group = $query->first();
        $companyId = $this->tenantCompanyId($data['company_id'] ?? ($group->company_id ?? 0));
        if (!$group || !$this->ownedBusinessUnit($data['bu_id'], $companyId)) {
            return response()->json(['message' => 'BU group not found'], 404);
        }
        $this->scopeWritableCompanyData(DB::table('bu_group'))->where('id', $id)->update([
            'title' => $data['title'], 'bu_id' => $data['bu_id'], 'company_id' => $companyId,
        ]);
        return response()->json(['message' => 'BU group updated successfully']);
    }

    public function companywise($id)
    {
        $query = DB::table('bu_group as s')->leftJoin('company as c', 's.company_id', '=', 'c.id')
            ->join('business_units as b', 's.bu_id', '=', 'b.id')
            ->selectRaw('s.*, IFNULL(c.name, "System") as company, b.name')->where('s.company_id', $id);
        $status = $this->scopeVisibleCompanyData($query, 's.company_id')->get();
        return response()->json($status);
    }

    public function destroy($id)
    {
        $query = $this->scopeWritableCompanyData(DB::table('bu_group'))->where('id', $id);
        if (!$query->exists()) {
            return response()->json(['message' => 'BU group not found'], 404);
        }
        $query->delete();
        return response()->json(['message' => 'BU group deleted successfully']);
    }

    private function ownedBusinessUnit($businessUnitId, $companyId)
    {
        $query = DB::table('business_units')->where('id', $businessUnitId);
        if ($companyId !== null) {
            $query->where('company_id', $companyId);
        }
        return $query->exists();
    }
}
