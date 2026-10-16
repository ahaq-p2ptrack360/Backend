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
    /**
     * Show upload form (existing)
     */
    public function showForm()
    {
        return view('ticket-upload-form');
    }

    /**
     * ✅ Helper: Get user ID based on role
     * 
     * Admin  -> request se user_id use karega (selected user)
     * Non-Admin -> logged-in user ki khud ki ID
     * 
     * @param Request $request
     * @return int|null
     */
    private function getUserId(Request $request)
    {
        $user = auth()->user();

        // Agar user null hai to request se lo
        if (!$user) {
            return $request->input('user_id');
        }

        // Admin check
        $isAdmin = ($user->role == 1 || $user->is_super_admin == 1);

        if ($isAdmin) {
            // ✅ Admin: request se user_id (ya apni khud ki ID fallback)
            return $request->input('user_id') ?? $user->id;
        } else {
            // ✅ Non-Admin: apni khud ki ID
            return $user->id;
        }
    }

    /**
     * Validate user ID
     */
    private function validateUserId($userId)
    {
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User ID is required.'
            ], 422);
        }

        return null;
    }

    /**
     * ✅ Import Tickets
     */
    public function Tickets(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv',
            'user_id'    => 'nullable|integer|exists:users,id',
        ]);

        // User ID resolve karo (role based)
        $userId = $this->getUserId($request);

        if ($errorResponse = $this->validateUserId($userId)) {
            return $errorResponse;
        }

        $file = $request->file('excel_file');

        try {
            // ✅ user_id import class ko pass karo
            Excel::import(new TicketsImport($userId), $file);

            return response()->json([
                'success' => true,
                'message' => 'Tickets imported successfully',
                'user_id' => $userId
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ Import Business Units
     */
    public function BU(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv',
            'user_id'    => 'nullable|integer|exists:users,id',
        ]);

        $userId = $this->getUserId($request);

        if ($errorResponse = $this->validateUserId($userId)) {
            return $errorResponse;
        }

        $file = $request->file('excel_file');

        try {
            Excel::import(new BuImport($userId), $file);

            return response()->json([
                'success' => true,
                'message' => 'Business Units imported successfully',
                'user_id' => $userId
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ Import Users
     */
    public function Users(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv',
            'user_id'    => 'nullable|integer|exists:users,id',
        ]);

        $userId = $this->getUserId($request);

        if ($errorResponse = $this->validateUserId($userId)) {
            return $errorResponse;
        }

        $file = $request->file('excel_file');

        try {
            Excel::import(new UserImport($userId), $file);

            return response()->json([
                'success' => true,
                'message' => 'Users imported successfully',
                'user_id' => $userId
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ Import Group Designation
     */
    public function Group(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv',
            'user_id'    => 'nullable|integer|exists:users,id',
        ]);

        $userId = $this->getUserId($request);

        if ($errorResponse = $this->validateUserId($userId)) {
            return $errorResponse;
        }

        $file = $request->file('excel_file');

        try {
            Excel::import(new group_designation($userId), $file);

            return response()->json([
                'success' => true,
                'message' => 'Group Designations imported successfully',
                'user_id' => $userId
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage()
            ], 500);
        }
    }
}