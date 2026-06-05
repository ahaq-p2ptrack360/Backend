<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    public function index()
    {
        $roles = DB::select('SELECT * FROM roles');
        return response()->json($roles);
    }

    public function company($id)
    {
        $roles = DB::select('SELECT * FROM roles where company_id=?',[$id]);
        return response()->json($roles);
    }
    public function store(Request $request)
    {
        $data = $request->all();

        // DB::insert('INSERT INTO roles (company_id, name,is_active) VALUES (?,?, ?)',
        //     [$data['company_id'], $data['title'],'1']);
        DB::insert('INSERT INTO roles (company_id, name, guard_name, is_active) VALUES (?,?,?,?)',
    [$data['company_id'], $data['title'], 'web', '1']);


        // DB::insert('INSERT INTO permission_role (role_id, permission_id) VALUES (?, ?)',
        //     [$data['role_id'], $data['permission_id']]);

        return response()->json(['message' => 'Role created successfully']);
    }

    public function show($id)
    {
        $role = DB::select('SELECT * FROM roles WHERE id = ?', [$id]);
        return response()->json($role);
    }

    public function update(Request $request,$id)
    {
        $data = $request->all();

        DB::update('UPDATE roles SET company_id = ?, name = ? WHERE id = ?', [$data['company_id'], $data['title'],$id]);

        return response()->json(['message' => 'Role updated successfully']);
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM roles WHERE id = ?', [$id]);
        return response()->json(['message' => 'Role deleted successfully']);
    }
}