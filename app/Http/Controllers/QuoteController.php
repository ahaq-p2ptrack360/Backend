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

    public function store(Request $request)
    {
        $data = $request->all();

        DB::insert('
          INSERT INTO `service_manager`.`qoutations`
          (`id`,
          `company_id`,
          `ticket_id`,
          `vendor_id`,
          `amount`,
          `approved_amount`,
          `actual_amount`,
          `description`,
          `created_by`,
          `updated_by`,
          `created_at`,
          `updated_at`,
          `deleted_at`,
          `approved_by`)
          VALUES
          (<{id: }>,
          <{company_id: }>,
          <{ticket_id: }>,
          <{vendor_id: }>,
          <{amount: }>,
          <{approved_amount: 0}>,
          <{actual_amount: 0}>,
          <{description: }>,
          <{created_by: }>,
          <{updated_by: }>,
          <{created_at: }>,
          <{updated_at: }>,
          <{deleted_at: }>,
          <{approved_by: }>);
          SELECT * FROM service_manager.qoutations;',
            [$data['company_id'], $data['title']]);

        DB::insert('INSERT INTO permission_role (role_id, permission_id) VALUES (?, ?)',
            [$data['role_id'], $data['permission_id']]);

        return response()->json(['message' => 'Role created successfully']);
    }

    public function show($id)
    {
        $role = DB::select('SELECT * FROM roles WHERE id = ?', [$id]);
        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        DB::update('UPDATE roles SET company_id = ?, title = ? WHERE id = ?', [$data['company_id'], $data['title'], $id]);

        return response()->json(['message' => 'Role updated successfully']);
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM roles WHERE id = ?', [$id]);
        return response()->json(['message' => 'Role deleted successfully']);
    }
}