<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = DB::table('notifications')->get();
        return response()->json($notifications);
    }

    public function store(Request $request)
    {
        $data = $request->only('type', 'data','created_by','company_id');
        
        $data['created_at'] = now(); // Set the current timestamp
        
        $notificationId = DB::table('notifications')->insertGetId($data);
        
        return response()->json(['message' => 'Notification created', 'id' => $notificationId]);
    }

    public function show($id)
    {
        $notification = DB::table('notifications')->find($id);

        if ($notification) {
            return response()->json($notification);
        } else {
            return response()->json(['message' => 'Notification not found'], 404);
        }
    }
    public function company($id,$u_id)
    {
        $noti = DB::select('SELECT * FROM notifications WHERE company_id = ? and created_by != ?  order by id desc limit 1', [$id,$u_id]);
        return response()->json($noti);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only('type', 'data');
        
        $updated = DB::table('notifications')->where('id', $id)->update($data);

        if ($updated) {
            return response()->json(['message' => 'Notification updated']);
        } else {
            return response()->json(['message' => 'Notification not found'], 404);
        }
    }

    public function destroy($id)
    {
        $deleted = DB::table('notifications')->where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Notification deleted']);
        } else {
            return response()->json(['message' => 'Notification not found'], 404);
        }
    }
}
