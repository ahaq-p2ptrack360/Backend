<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SubscriptionPackageController extends Controller
{
    public function index()
    {
        $packages = DB::select('SELECT * FROM subscription_package where active =1');
        return response()->json($packages);
    }

    public function store(Request $request)
    {
        if (!$this->isPlatformAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $data = $request->validate(['title' => 'required|string|max:255', 'price' => 'required|numeric|min:0', 'no_of_licence' => 'required|integer|min:0', 'description' => 'nullable|string']);

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
        if (!$this->isPlatformAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $data = $request->validate(['title' => 'required|string|max:255', 'price' => 'required|numeric|min:0', 'no_of_licence' => 'required|integer|min:0', 'description' => 'nullable|string']);

        DB::update('UPDATE subscription_package SET title = ?, price = ?, no_of_licence = ?, description = ? WHERE id = ?',
            [$data['title'], $data['price'], $data['no_of_licence'], $data['description'], $id]);

        return response()->json(['message' => 'Subscription package updated successfully']);
    }

    public function destroy($id)
    {
        if (!$this->isPlatformAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        DB::delete('DELETE FROM subscription_package WHERE id = ?', [$id]);
        return response()->json(['message' => 'Subscription package deleted successfully']);
    }

    public function updatesubstatus(Request $request)
    {
        if (!$this->isPlatformAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $data = $request->validate(['active' => 'required|boolean', 'id' => 'required|integer']);
        DB::table('subscription_package')->where('id', $data['id'])->update(['active' => $data['active']]);
        return response()->json(['message' => 'Subscription package status updated successfully']);
    }

    private function isPlatformAdmin()
    {
        return Auth::user() && (int) Auth::user()->company_id === 0;
    }
}