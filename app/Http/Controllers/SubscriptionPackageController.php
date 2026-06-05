<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionPackageController extends Controller
{
    public function index()
    {
        $packages = DB::select('SELECT * FROM subscription_package where active =1');
        return response()->json($packages);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        DB::insert('INSERT INTO subscription_package (title, price, no_of_licence, description) VALUES (?, ?, ?, ?)',
            [$data['title'], $data['price'], $data['no_of_licence'], $data['description']]);

        return response()->json(['message' => 'Subscription package created successfully']);
    }

    public function show($id)
    {
        $package = DB::select('SELECT * FROM subscription_package WHERE id = ?', [$id]);
        return response()->json($package);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        DB::update('UPDATE subscription_package SET title = ?, price = ?, no_of_licence = ?, description = ? WHERE id = ?',
            [$data['title'], $data['price'], $data['no_of_licence'], $data['description'], $id]);

        return response()->json(['message' => 'Subscription package updated successfully']);
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM subscription_package WHERE id = ?', [$id]);
        return response()->json(['message' => 'Subscription package deleted successfully']);
    }
}