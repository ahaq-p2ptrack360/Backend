<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Concerns\ScopesTenantCompanyData;

class GroupMemberController extends Controller
{
    use ScopesTenantCompanyData;

    public function index()
    {
        $query = DB::table('bu_group_members as bg')
            ->leftJoin('bu_group as g', 'bg.group_id', '=', 'g.id')
            ->leftJoin('users as mem', 'bg.member_id', '=', 'mem.id')
            ->leftJoin('users as m', 'bg.user_id', '=', 'm.id')
            ->selectRaw('bg.group_id, g.title AS group_name, GROUP_CONCAT(mem.first_name) AS members, m.name AS manager')
            ->groupBy('bg.group_id', 'g.title', 'm.name');
        $companyId = $this->tenantCompanyId();
        if ($companyId !== null && (int) $companyId !== 0) {
            $query->where('g.company_id', $companyId);
        }
        $groupMembers = $query->get();
    
        return response()->json($groupMembers);
    }
    
    public function u_group_store(Request $request)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'company_id' => 'nullable|integer']);
        DB::insert('INSERT INTO u_group (title, company_id) VALUES (?, ?)', [$data['title'], $this->tenantCompanyId($data['company_id'] ?? 0)]);
        $id = DB::getPdo()->lastInsertId();
        return response()->json(['message' => 'Group created successfully','id'=>$id]);
    }

    public function u_group_admin()
    {
        $query = DB::table('bu_group_members as m')->join('u_group as ug', 'm.group_id', '=', 'ug.id')
            ->join('users as u', 'u.id', '=', 'm.member_id')
            ->selectRaw('ug.title, GROUP_CONCAT(u.first_name) as members, ug.created_at')
            ->groupBy('ug.title', 'ug.created_at');
        $companyId = $this->tenantCompanyId();
        if ($companyId !== null && (int) $companyId !== 0) {
            $query->where('ug.company_id', $companyId)->where('u.company_id', $companyId);
        }
        $groupMembers = $query->get();
        return response()->json($groupMembers);
    }

    public function u_group_companywise($id)
    {
        $companyId = $this->tenantCompanyId($id);
        $query = DB::table('bu_group_members as m')->join('u_group as ug', 'm.group_id', '=', 'ug.id')
            ->join('users as u', 'u.id', '=', 'm.member_id')
            ->selectRaw('ug.id as group_id, ug.title, GROUP_CONCAT(u.first_name) AS members, ug.created_at')
            ->where('ug.company_id', $companyId)->groupBy('ug.id', 'ug.title', 'ug.created_at');
        if ($this->tenantCompanyId() !== null && (int) $this->tenantCompanyId() !== 0) {
            $query->where('u.company_id', $companyId);
        }
        $groupMembers = $query->get();
        
        return response()->json($groupMembers);
    }
    public function u_group_company($id)
    {
        $companyId = $this->tenantCompanyId($id);
        $groupMembers = DB::table('u_group')->where('company_id', $companyId)->get();
        return response()->json($groupMembers);
    }
    public function store(Request $request)
    {
        $data = $request->validate(['group_id' => 'required|integer', 'member_id' => 'required|integer', 'user_id' => 'required|integer']);
        $group = $this->scopeWritableCompanyData(DB::table('bu_group'))->where('id', $data['group_id'])->first();
        if (!$group || !$this->usersBelongToCompany([$data['member_id'], $data['user_id']], $group->company_id)) {
            return response()->json(['message' => 'Group or users not found'], 404);
        }
        DB::insert('INSERT INTO bu_group_members (group_id, member_id,user_id) VALUES (?,?, ?)', [$data['group_id'], $data['member_id'], $data['user_id']]);
        return response()->json(['message' => 'Group member created successfully']);
    }

    public function show($id)
    {
        $query = DB::table('bu_group_members as bg')->join('bu_group as g', 'bg.group_id', '=', 'g.id')
            ->where('bg.id', $id);
        $companyId = $this->tenantCompanyId();
        if ($companyId !== null && (int) $companyId !== 0) {
            $query->where('g.company_id', $companyId);
        }
        $groupMember = $query->get(['bg.*']);
        return response()->json($groupMember);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['group_id' => 'required|integer', 'member_id' => 'required|integer', 'user_id' => 'required|integer']);
        $existing = DB::table('bu_group_members as m')->join('bu_group as g', 'm.group_id', '=', 'g.id')
            ->where('m.id', $id)->when($this->tenantCompanyId() !== null && (int) $this->tenantCompanyId() !== 0, function ($query) {
                $query->where('g.company_id', $this->tenantCompanyId());
            })->first(['m.id']);
        $group = $this->scopeWritableCompanyData(DB::table('bu_group'))->where('id', $data['group_id'])->first();
        if (!$existing || !$group || !$this->usersBelongToCompany([$data['member_id'], $data['user_id']], $group->company_id)) {
            return response()->json(['message' => 'Group member or users not found'], 404);
        }
        DB::table('bu_group_members')->where('id', $id)->update([
            'group_id' => $data['group_id'], 'member_id' => $data['member_id'], 'user_id' => $data['user_id'],
        ]);
        return response()->json(['message' => 'Group member updated successfully']);
    }

    public function companywise($id)
    {
        if (!$this->scopeVisibleCompanyData(DB::table('bu_group'))->where('id', $id)->exists()) {
            return response()->json(['message' => 'Group not found'], 404);
        }
        $status = DB::table('bu_group_members')->where('group_id', $id)->get();
        return response()->json($status);
    }

    public function destroy($id)
    {
        $query = DB::table('bu_group_members as m')->join('bu_group as g', 'm.group_id', '=', 'g.id')->where('m.id', $id);
        $companyId = $this->tenantCompanyId();
        if ($companyId !== null && (int) $companyId !== 0) {
            $query->where('g.company_id', $companyId);
        }
        if (!$query->exists()) {
            return response()->json(['message' => 'Group member not found'], 404);
        }
        DB::table('bu_group_members')->where('id', $id)->delete();
        return response()->json(['message' => 'Group member deleted successfully']);
    }
    public function destroygroup($id)
    {
        if (!$this->scopeWritableCompanyData(DB::table('bu_group'))->where('id', $id)->exists()) {
            return response()->json(['message' => 'Group not found'], 404);
        }
        DB::table('bu_group_members')->where('group_id', $id)->delete();
        return response()->json(['message' => 'Group members deleted successfully']);
    }

    private function usersBelongToCompany(array $userIds, $companyId)
    {
        $query = DB::table('users')->whereIn('id', $userIds);
        $query->where('company_id', $companyId);
        return $query->count() === count(array_unique($userIds));
    }
}

