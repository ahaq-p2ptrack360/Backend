<?php
// app/Http/Controllers/GroupController.php
// app/Http/Controllers/GroupController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function createAndAddUsers(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        // Create the group
        $group = Group::create([
            'name' => $request->group_name,
        ]);

        // Attach the selected users to the group
        $group->users()->attach($request->user_ids);

        return redirect()->route('chatify')->with('success', 'Group created and users added successfully');
    }

    public function joinGroup(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
        ]);

        $group = Group::findOrFail($request->group_id);

        // Add the current user to the group
        $group->users()->attach(Auth::id());

        return response()->json(['message' => 'Joined group successfully', 'data' => $group]);
    }

    public function addUserToGroup(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $group = Group::findOrFail($request->group_id);

        // Add the selected user to the group
        $group->users()->attach($request->user_id);

        return response()->json(['message' => 'User added to group successfully', 'data' => $group]);
    }
}
