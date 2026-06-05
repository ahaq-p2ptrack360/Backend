<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuFieldController extends Controller
{
    public function index()
    {
        $buFields = DB::select('SELECT * FROM bu_fields');
        return response()->json($buFields);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        DB::insert(
            'INSERT INTO bu_fields (name, type, bu_id) VALUES (?, ?, ?)',
            [$data['name'], $data['type'], $data['bu_id']]
        );

        return response()->json(['message' => 'Business Unit Field created successfully']);
    }
    public function bu_field_data(Request $request)
    {
        $data = $request->all();

        DB::insert(
            'INSERT INTO `bu_field_data`( `field_id`, `bu_id`, `Ticket_id`, `field_data`) VALUES (?, ?, ?,?)',
            [$data['field_id'], $data['bu_id'], $data['Ticket_id'],$data['field_data']]
        );

        return response()->json(['message' => 'Business Unit Field Data created successfully']);
    }

    public function show($id)
    {
        $buField = DB::select('SELECT * FROM bu_fields WHERE bu_id = ?', [$id]);
        return response()->json($buField);
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM bu_fields WHERE bu_id = ?', [$id]);
        return response()->json(['message' => 'Business Unit Field deleted successfully']);
    }
}
