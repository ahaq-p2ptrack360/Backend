<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DomainController extends Controller
{
    public function index()
    {
        $domains = DB::select('SELECT * FROM domains where active =1');
        return response()->json($domains);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        DB::insert('INSERT INTO domains (title, status,eligible) VALUES (?, ?,?)',
            [$data['title'], $data['status'], $data['eligible']]);
            $insertedId = DB::getPdo()->lastInsertId();

            return response()->json(['message' => 'Domain created successfully', 'inserted_id' => $insertedId]);
        
        return response()->json(['message' => 'Domain created successfully','id'=>$id]);
    }

    public function show($id)
    {
        $domain = DB::select('SELECT * FROM domains WHERE id = ? ', [$id]);
        return response()->json($domain);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        DB::update('UPDATE domains SET title = ?, status = ? WHERE id = ?', [$data['title'], $data['status'], $id]);

        return response()->json(['message' => 'Domain updated successfully']);
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM domains WHERE id = ?', [$id]);
        return response()->json(['message' => 'Domain deleted successfully']);
    }
    public function domainstore(Request $request)
    {
        $data = $request->all();

        DB::insert(
            'INSERT INTO `domain_fields`(`domain_id`, `name`, `type`) VALUES (?,?,?)',
            [$data['domain_id'],$data['name'], $data['type']]
        );

        return response()->json(['message' => 'Domain Field created successfully']);
    }
    public function domain_fields($id)
    {
        $domain_fields = DB::select('SELECT * FROM `domain_fields` WHERE domain_id=?', [$id]);
        return response()->json($domain_fields);
    }

    public function domain_field_datastore(Request $request)
    {
        $data = $request->all();
        // dd($request->all());
        DB::insert(
            'INSERT INTO `domain_field_data`(`field_id`, `domain_id`, `company_id`, `field_data`) VALUES (?,?,?,?)',
            [$data['field_id'],$data['domain_id'], $data['company_id'], $data['field_data']]
        );

        return response()->json(['message' => 'Domain Field Data created successfully']);
    }

    public function updatedoaminstatus(Request $request)
{
    $data = $request->all();

    DB::update(
        'UPDATE domains SET active = ? WHERE id = ?',
        [$data['active'], $data['id']]
    );

    return response()->json([
        'success' => true,
        'message' => 'Domain status updated successfully'
    ]);
}

    

}

