<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;  // Remove this if not using

class UserNotificationController extends Controller
{
    /**
     * Get all notifications for current user
     */
   // UserNotificationController.php

public function index(Request $request)
{
    try {
        $userId = $request->user_id ?? $request->input('user_id');
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User ID is required'
            ], 400);
        }
        
        // 🔥 Fetch user from database
        $user = DB::table('users')->where('id', $userId)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
        
        $userCompanyId = $user->company_id;
        
        \Log::info('Fetching notifications', [
            'user_id' => $userId,
            'user_company_id' => $userCompanyId
        ]);
        
        // 🔥 CRITICAL: Sirf us company ke notifications dikhao jis company se user belong karta hai
        $notifications = UserNotification::where(function($query) use ($userCompanyId) {
                // Company-specific notifications
                $query->where('company_id', $userCompanyId);
                
                // Agar user ki company_id null hai (admin) to sab dikhao
                if ($userCompanyId === null) {
                    $query->orWhereNull('company_id');
                }
            })
            ->latest()
            ->take(50)
            ->get();
        
        \Log::info('Notifications fetched', [
            'count' => $notifications->count(),
            'company_id_filter' => $userCompanyId
        ]);
        
        // Format data
        $formatted = $notifications->map(function($notification) {
            $data = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
            
            return [
                'id' => $notification->id,
                'type' => $notification->type,
                'title' => $notification->title,
                'message' => $notification->message,
                'data' => $data,
                'ticket_id' => $notification->ticket_id,
                'is_read' => $notification->is_read,
                'company_id' => $notification->company_id,
                'created_at' => $notification->created_at,
                'read_at' => $notification->read_at,
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $formatted,
            'user_company' => $userCompanyId
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error fetching notifications: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
    
    /**
     * Get unread notification count
     */
    public function unreadCount(Request $request)
{
    try {
        // Get user ID from request (jo bhi aaye)
        $userId = $request->user_id ?? $request->input('user_id');
        
        // Default values
        $totalCount = 0;
        $userCompanyId = null;
        
        // Agar user ID hai to count karo, warna 0 return karo
        if ($userId) {
            // Fetch user from database
            $user = DB::table('users')->where('id', $userId)->first();
            
            if ($user) {
                $userCompanyId = $user->company_id;
                
                // Sirf us company ke notifications ka count
                $query = UserNotification::where(function($q) use ($userCompanyId) {
                    $q->where('company_id', $userCompanyId);
                    
                    if ($userCompanyId === null) {
                        $q->orWhereNull('company_id');
                    }
                });
                
                $totalCount = $query->count();
            }
        }
        
        // Sirf ye JSON return karo - NO ERROR MESSAGES
        return response()->json([
            'success' => true,
            'count' => $totalCount,
            'company_id' => $userCompanyId
        ]);
        
    } catch (\Exception $e) {
        // Error me bhi success=true return karo
        return response()->json([
            'success' => true,
            'count' => 0,
            'company_id' => null
        ]);
    }
}
    
    /**
     * Mark single notification as read
     */
    public function markAsRead($id, Request $request)
    {
        try {
            // 🔥 Get user_id from request
            $userId = $request->user_id ?? $request->input('user_id');
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ID is required'
                ], 400);
            }
            
            // Fetch user
            $user = DB::table('users')->where('id', $userId)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }
            
            $notification = UserNotification::findOrFail($id);
            $userCompanyId = $user->company_id ?? null;
            
            // Check permission
            if ($userCompanyId !== null && $notification->company_id !== null && $notification->company_id != $userCompanyId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            $notification->update([
                'is_read' => true,
                'read_at' => now()
            ]);
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Mark all notifications as read
     */
    public function markAllRead(Request $request)
    {
        try {
            // 🔥 Get user_id from request
            $userId = $request->user_id ?? $request->input('user_id');
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ID is required'
                ], 400);
            }
            
            // Fetch user
            $user = DB::table('users')->where('id', $userId)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }
            
            $userCompanyId = $user->company_id ?? null;
            
            if ($userCompanyId === null) {
                // Admin - mark all as read
                UserNotification::where('is_read', false)
                    ->update(['is_read' => true, 'read_at' => now()]);
            } else {
                // Company user - mark only their company's notifications as read
                UserNotification::where('company_id', $userCompanyId)
                    ->orWhereNull('company_id')
                    ->where('is_read', false)
                    ->update(['is_read' => true, 'read_at' => now()]);
            }
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            \Log::error('Mark all read error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Delete notifications
     */
    public function delete(Request $request)
    {
        try {
            // 🔥 Get user_id from request
            $userId = $request->user_id ?? $request->input('user_id');
            $ids = $request->ids;
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ID is required'
                ], 400);
            }
            
            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No IDs provided'
                ], 400);
            }
            
            // Fetch user
            $user = DB::table('users')->where('id', $userId)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }
            
            $userCompanyId = $user->company_id ?? null;
            
            if ($userCompanyId === null) {
                // Admin - can delete any notifications
                UserNotification::whereIn('id', $ids)->delete();
            } else {
                // Company user - can only delete their company's notifications
                UserNotification::whereIn('id', $ids)
                    ->where(function($query) use ($userCompanyId) {
                        $query->where('company_id', $userCompanyId)
                              ->orWhereNull('company_id');
                    })
                    ->delete();
            }
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            \Log::error('Delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}