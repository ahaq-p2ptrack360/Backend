<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Concerns\ScopesTenantCompanyData;


class RoleController extends Controller
{
    use ScopesTenantCompanyData;

    public function index()
    {
        $roles = $this->scopeVisibleCompanyData(DB::table('roles'))->get();
        return response()->json($roles);
    }

    public function company($id)
    {
        $roles = $this->scopeVisibleCompanyData(DB::table('roles'))
            ->where('company_id', $id)->get();
        return response()->json($roles);
    }
    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'company_id' => 'nullable|integer']);

        // DB::insert('INSERT INTO roles (company_id, name,is_active) VALUES (?,?, ?)',
        //     [$data['company_id'], $data['title'],'1']);
        DB::insert('INSERT INTO roles (company_id, name, guard_name, is_active) VALUES (?,?,?,?)',
    [$this->tenantCompanyId($data['company_id'] ?? 0), $data['title'], 'web', '1']);


        // DB::insert('INSERT INTO permission_role (role_id, permission_id) VALUES (?, ?)',
        //     [$data['role_id'], $data['permission_id']]);

        return response()->json(['message' => 'Role created successfully']);
    }

    public function show($id)
    {
        $role = $this->scopeVisibleCompanyData(DB::table('roles'))
            ->where('id', $id)->get();
        return response()->json($role);
    }

    public function update(Request $request,$id)
    {
        $data = $request->validate(['title' => 'required|string|max:255', 'company_id' => 'nullable|integer']);

        $query = $this->scopeWritableCompanyData(DB::table('roles'));
        $existing = $query->where('id', $id)->first();
        if (!$existing) {
            return response()->json(['message' => 'Role not found'], 404);
        }
        $this->scopeWritableCompanyData(DB::table('roles'))->where('id', $id)->update([
            'company_id' => $this->tenantCompanyId($data['company_id'] ?? $existing->company_id),
            'name' => $data['title'],
        ]);

        return response()->json(['message' => 'Role updated successfully']);
    }

    public function destroy($id)
    {
        $query = $this->scopeWritableCompanyData(DB::table('roles'))->where('id', $id);
        if (!$query->exists()) {
            return response()->json(['message' => 'Role not found'], 404);
        }
        $query->delete();
        return response()->json(['message' => 'Role deleted successfully']);
    }
}