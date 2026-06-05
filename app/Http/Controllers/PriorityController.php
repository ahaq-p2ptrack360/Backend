<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriorityController extends Controller
{
    public function index()
    {
        $priorities = DB::select('SELECT s.*,IFNULL(c.name,"System") as company FROM `priority` s left join company c on s.company_id = c.id where s.active =1;');
        return response()->json($priorities);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        DB::insert('INSERT INTO priority (company_id, title, active, sla) VALUES (?, ?, ?, ?)', [$data['company_id'], $data['title'], $data['active'], $data['sla']]);
        return response()->json(['message' => 'Priority created successfully']);
    }

    public function show($id)
    {
        $priority = DB::select('SELECT * FROM priority WHERE id = ?', [$id]);
        return response()->json($priority);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        DB::update('UPDATE priority SET company_id = ?, title = ?, active = ?, sla = ? WHERE id = ?', [$data['company_id'], $data['title'], $data['active'], $data['sla'], $id]);
        return response()->json(['message' => 'Priority updated successfully']);
    }


    public function companywise($id)
    {
        $status = DB::select('SELECT s.*,IFNULL(c.name,"System") as company FROM `priority` s left join company c on s.company_id = c.id WHERE company_id = ? and s.active=1', [$id]);
        return response()->json($status);
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM priority WHERE id = ?', [$id]);
        return response()->json(['message' => 'Priority deleted successfully']);
    }
    
    public function updateprioritystatus(Request $request)
    {
        $data = $request->all();
        DB::update('UPDATE priority SET active = ? WHERE id = ?', [
            $data['active'],
            $data['id']
          
        ]);
        return response()->json(['message' => 'Priority status updated successfully']);
    }
}
