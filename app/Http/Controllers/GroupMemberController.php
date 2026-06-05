<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupMemberController extends Controller
{
    public function index()
    {
        $groupMembers = DB::select("
            SELECT
                bg.group_id,
                g.title AS group_name,
                GROUP_CONCAT(mem.first_name) AS members,
                m.name AS manager
            FROM bu_group_members bg
            LEFT JOIN bu_group g ON bg.group_id = g.id
            LEFT JOIN users mem ON bg.member_id = mem.id
            LEFT JOIN users m ON bg.user_id = m.id
            GROUP BY bg.group_id, g.title, m.name
        ");
    
        return response()->json($groupMembers);
    }
    
    public function u_group_store(Request $request)
    {
        $data = $request->all();
        DB::insert('INSERT INTO u_group (title, company_id) VALUES (?, ?)', [$data['title'], $data['company_id']]);
        $id = DB::getPdo()->lastInsertId();
        return response()->json(['message' => 'Group created successfully','id'=>$id]);
    }

    public function u_group_admin()
    {
        $groupMembers = DB::select('SELECT ug.title, GROUP_CONCAT(u.first_name) as members, ug.created_at
        FROM bu_group_members m
        INNER JOIN u_group ug ON m.group_id = ug.id
        INNER JOIN users u ON u.id = m.member_id
        GROUP BY ug.title, ug.created_at;
        ' );
        return response()->json($groupMembers);
    }

    public function u_group_companywise($id)
    {
        $groupMembers = DB::select("
            SELECT 
                ug.id as group_id,
                ug.title, 
                GROUP_CONCAT(u.first_name) AS members,
                ug.created_at
            FROM bu_group_members m
            INNER JOIN u_group ug ON m.group_id = ug.id
            INNER JOIN users u ON u.id = m.member_id
            WHERE ug.company_id = ?
            GROUP BY ug.id, ug.title, ug.created_at
        ", [$id]);
        
        return response()->json($groupMembers);
    }
    public function u_group_company($id)
    {
        $groupMembers = DB::select('SELECT *
        FROM u_group
        WHERE company_id = '.$id.'' );
        return response()->json($groupMembers);
    }
    public function store(Request $request)
    {
        $data = $request->all();
        DB::insert('INSERT INTO bu_group_members (group_id, member_id,user_id) VALUES (?,?, ?)', [$data['group_id'], $data['member_id'],$data['user_id']]);
        return response()->json(['message' => 'Group member created successfully']);
    }

    public function show($id)
    {
        $groupMember = DB::select('SELECT * FROM bu_group_members bg join group g on bg.group_id join =  WHERE id = ?', [$id]);
        return response()->json($groupMember);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        DB::update('UPDATE bu_group_members SET group_id = ?, member_id = ?,user_id=? WHERE id = ?', [$data['user_id'],$data['group_id'], $data['member_id'], $id]);
        return response()->json(['message' => 'Group member updated successfully']);
    }

    public function companywise($id)
    {
        $status = DB::select('SELECT * FROM bu_group_members WHERE group_id = ?', [$id]);
        return response()->json($status);
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM bu_group_members WHERE id = ?', [$id]);
        return response()->json(['message' => 'Group member deleted successfully']);
    }
    public function destroygroup($id)
    {
        DB::delete('DELETE FROM bu_group_members WHERE group_id = ?', [$id]);
        return response()->json(['message' => 'Group members deleted successfully']);
    }
}

