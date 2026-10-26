<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeController extends Controller
{
    public function index()
    {
        $types = DB::select('SELECT CASE WHEN t1.company_id = "0" THEN "System" ELSE c.name END as company, t1.id, t1.title,t1.active,t1.created_at, t1.parent_id, t2.title as parent FROM types t1 left JOIN types t2 ON t1.parent_id = t2.id  left join company c on t1.company_id = c.id where t1.active=1;');
        return response()->json($types);
    }


    public function companywise($id)
    {
        $type = DB::select('SELECT CASE WHEN t1.company_id = "0" THEN "System" ELSE c.name END as company, t1.id,t1.active, t1.title, t1.parent_id,t1.created_at, t2.title as parent FROM types t1 left JOIN types t2 ON t1.parent_id = t2.id  left join company c on t1.company_id = c.id WHERE c.id = ? and t1.active=1', [$id]);
        return response()->json($type);
    }


    public function store(Request $request)
    {
        $data = $request->all();
        DB::insert('INSERT INTO types (company_id, title, parent_id, active) VALUES (?, ?, ?, ?)', [
            $data['company_id'],
            $data['title'],
            $data['parent_id'],
            $data['active']
        ]);
        return response()->json(['message' => 'Type created successfully']);
    }

    public function show($id)
    {
        $type = DB::select('SELECT * FROM types WHERE id = ?', [$id]);
        return response()->json($type);
    }

    public function parent($id)
    {
        $type = DB::select('SELECT * FROM types WHERE parent_id = ?', [$id]);
        return response()->json($type);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        DB::update('UPDATE types SET company_id = ?, title = ?, parent_id = ?, active = ? WHERE id = ?', [
            $data['company_id'],
            $data['title'],
            $data['parent_id'],
            $data['active'],
            $id
        ]);
        return response()->json(['message' => 'Type updated successfully']);
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM types WHERE id = ?', [$id]);
        return response()->json(['message' => 'Type deleted successfully']);
    }

    public function updatetypestatus(Request $request)
    {
        $data = $request->all();
        DB::update('UPDATE types SET active = ? WHERE id = ?', [
            $data['active'],
            $data['id']
          
        ]);
        return response()->json(['message' => 'Type status updated successfully']);
    }
}
