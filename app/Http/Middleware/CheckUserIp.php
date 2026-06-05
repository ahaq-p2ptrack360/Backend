<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class CheckUserIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
        public function handle(Request $request, Closure $next)
        {
            if (!Auth::check()) {
                return redirect()->route('login'); // Redirect if not authenticated
            }
    
            $user = Auth::user();
            $status = $user->status; // Get client IP
            dd($status);
            // Check if the request IP matches stored IPs
            // dd($status);
            if ($status !== "0") {
                Auth::logout(); // Logout user
                // dd("First logout from the last device");
                return redirect()->route('login')->withErrors(['ip' => 'Logout from the last device']);
            }
            else {
                DB::table('users')->where('id', Auth::id())->update(['status' => 1]);
            }
    
            return $next($request);
        }    }
