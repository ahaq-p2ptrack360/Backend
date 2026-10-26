<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Concerns\ScopesTenantCompanyData;

class NotificationController extends Controller
{
    use ScopesTenantCompanyData;

    public function index()
    {
        $notifications = $this->scopeWritableCompanyData(DB::table('notifications'))->get();
        return response()->json($notifications);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['type' => 'required|string|max:255', 'data' => 'nullable', 'company_id' => 'nullable|integer']);
        $data['company_id'] = $this->tenantCompanyId($data['company_id'] ?? 0);
        $data['created_by'] = Auth::id();
        
        $data['created_at'] = now(); // Set the current timestamp
        
        $notificationId = DB::table('notifications')->insertGetId($data);
        
        return response()->json(['message' => 'Notification created', 'id' => $notificationId]);
    }

    public function show($id)
    {
        $notification = $this->scopeWritableCompanyData(DB::table('notifications'))->where('id', $id)->first();

        if ($notification) {
            return response()->json($notification);
        } else {
            return response()->json(['message' => 'Notification not found'], 404);
        }
    }
    public function company($id,$u_id)
    {
        $companyId = $this->tenantCompanyId($id);
        $noti = DB::table('notifications')->where('company_id', $companyId)
            ->where('created_by', '!=', Auth::id())->orderByDesc('id')->limit(1)->get();
        return response()->json($noti);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['type' => 'sometimes|required|string|max:255', 'data' => 'sometimes|nullable']);
        
        $updated = $this->scopeWritableCompanyData(DB::table('notifications'))->where('id', $id)->update($data);

        if ($updated) {
            return response()->json(['message' => 'Notification updated']);
        } else {
            return response()->json(['message' => 'Notification not found'], 404);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->scopeWritableCompanyData(DB::table('notifications'))->where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Notification deleted']);
        } else {
            return response()->json(['message' => 'Notification not found'], 404);
        }
    }
}
