<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\AllImport;
use App\Imports\BuImport;
use App\Imports\group_designation;
use App\Imports\TicketsImport;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;


class Ticket_import_Controller extends Controller
{
    public function showForm()
    {
        return view('ticket-upload-form');
    }

    public function Tickets(Request $request)
    {
    
       $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('excel_file');

        Excel::import(new TicketsImport, $file);


        return response()->json(['message' => 'Ticket Inserted successfully']);


    }

    public function BU(Request $request)
    {
       $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('excel_file');

        Excel::import(new BuImport, $file);

        return response()->json(['message' => 'BU Inserted successfully']);


    }


    public function Users(Request $request)
    {
        
       $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('excel_file');

        Excel::import(new UserImport, $file);
        
        return response()->json(['message' => 'User Inserted successfully']);


    }

    public function Group(Request $request)
    {
       $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('excel_file');

        Excel::import(new group_designation, $file);

        return response()->json(['message' => 'Group Inserted successfully']);


    }

}

