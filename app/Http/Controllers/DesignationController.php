<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = DB::select('SELECT s.*,IFNULL(c.name,"System") as company FROM `designations` s left join company c on s.company_id = c.id where s.active=1');
        return response()->json($designations);
    }
    public function designation($id){
        $dname=DB::select('SELECT d.title
        FROM users u
        JOIN designations d
        ON u.designation_id=d.id
        WHERE u.designation_id=?',[$id]);
        return response()->json($dname);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        DB::insert('INSERT INTO designations (company_id, title, active) VALUES (?, ?, ?)',
            [$data['company_id'], $data['title'], $data['active']]);

        return response()->json(['message' => 'Designation created successfully']);
    }

    public function show($id)
    {
        $designation = DB::select('SELECT * FROM designations WHERE id = ?', [$id]);
        return response()->json($designation);
    }

    public function companywise($id)
    {
        $designations = DB::select('SELECT s.*,IFNULL(c.name,"System") as company FROM `designations` s left join company c on s.company_id = c.id  WHERE c.id = ? and s.active=1', [$id]);
        return response()->json($designations);
    }
    public function update(Request $request, $id)
    {
        $data = $request->all();

        DB::update('UPDATE designations SET company_id = ?, title = ?, active = ? WHERE id = ?', [$data['company_id'], $data['title'], $data['active'], $id]);

        return response()->json(['message' => 'Designation updated successfully']);
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM designations WHERE id = ?', [$id]);
        return response()->json(['message' => 'Designation deleted successfully']);
    }
    public function updatedesigstatus(Request $request)
    {
        $data = $request->all();
        DB::update('UPDATE designations  SET active = ? WHERE id = ?', [
            $data['active'],
            $data['id']
          
        ]);
        return response()->json(['message' => 'Type status updated successfully']);
    }
}

