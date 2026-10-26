<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use \Illuminate\Foundation\Auth\AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * SIMPLE LOGIN METHOD - Previous user ID store karna hai
     */
    public function login(Request $request)
    {
        \Log::info('LOGIN FUNCTION START', ['email_entered' => $request->input($this->username())]);
    
        // DEBUG: Check all cookies
        \Log::info('ALL COOKIES FROM REQUEST', [
            'cookies' => $request->cookies->all(),
            'has_user_id_cookie' => $request->hasCookie('user_id'),
            'has_previous_user_cookie' => $request->hasCookie('previous_user_id')
        ]);
        
        // Agar previous_user_id cookie hai to decrypt karo
        if ($request->hasCookie('previous_user_id')) {
            try {
                $decrypted = decrypt($request->cookie('previous_user_id'));
                \Log::info('PREVIOUS USER COOKIE FOUND', ['decrypted_value' => $decrypted]);
            } catch (\Exception $e) {
                \Log::error('COOKIE DECRYPT FAILED', ['error' => $e->getMessage()]);
            }
        }
    
        $this->validateLogin($request);

        // Check for too many login attempts
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // CURRENTLY LOGGED IN USER (admin agar koi pehle se login hai)
        $currentlyLoggedInUserId = Auth::id();
        Log::info('CURRENTLY LOGGED IN USER', ['user_id' => $currentlyLoggedInUserId]);

        // Attempt login with new user
        if ($this->attemptLogin($request)) {
            $newLoggedInUserId = Auth::id();
            
            // IMPORTANT: Previous user ID store karo agar koi pehle se login tha
            if ($currentlyLoggedInUserId && $currentlyLoggedInUserId != $newLoggedInUserId) {
                // Yahan par previous user ID store ho rahi hai
                DB::table('users')
                    ->where('id', $newLoggedInUserId)
                    ->update(['previous_user' => $currentlyLoggedInUserId]);
                
                Log::info('✅ PREVIOUS USER ID STORED IN DATABASE', [
                    'current_user' => $newLoggedInUserId,
                    'previous_user_stored' => $currentlyLoggedInUserId
                ]);
            }

            // Generate SSO token
            $plainToken = bin2hex(random_bytes(32));
            $hashedToken = hash('sha256', $plainToken);
            
            DB::table('users')->where('id', $newLoggedInUserId)->update([
                'sso_token' => $hashedToken,
                'status' => 1
            ]);

            // Store in session
            $userWithBU = DB::table('users')
                ->leftJoin('business_units', 'business_units.id', '=', 'users.bu_id')
                ->select('users.*', 'business_units.name as business_unit_name')
                ->where('users.id', $newLoggedInUserId)
                ->first();
            
            $request->session()->put('userWithBU', $userWithBU);

            // Clear login attempts
            $this->clearLoginAttempts($request);

            // Prepare response with cookies
            $response = $this->sendLoginResponse($request);
            
            // Set cookies
            $response->cookie('user_id', encrypt($newLoggedInUserId), 60 * 24, '/', null, true, true);
            $response->cookie('auth_token', $plainToken, 60 * 24, '/', null, true, true);
            
            // Previous user cookie set karo
            if ($currentlyLoggedInUserId && $currentlyLoggedInUserId != $newLoggedInUserId) {
                $response->cookie('previous_user_id', encrypt($currentlyLoggedInUserId), 60 * 24, '/', null, true, true);
            }

            Log::info('✅ LOGIN SUCCESS WITH PREVIOUS USER', [
                'new_user' => $newLoggedInUserId,
                'previous_user' => $currentlyLoggedInUserId
            ]);

            return $response;
        }

        // Login failed
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * SIMPLE LOGOUT METHOD
     */
    public function logout(Request $request)
    {
        Log::info('LOGOUT FUNCTION START');
        
        $currentUser = Auth::user();
        
        if (!$currentUser) {
            return redirect('/login');
        }
        
        $currentUserId = $currentUser->id;
        
        Log::info('LOGOUT DATA BEFORE', [
            'current_user_id' => $currentUserId,
            'previous_user_db' => $currentUser->previous_user
        ]);
        
        // Update current user status
        DB::table('users')
            ->where('id', $currentUserId)
            ->update([
                'sso_token' => null,
                'status' => 0
            ]);
        
        // Logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Prepare response - store current user ID in cookie for next login
        $response = redirect('/login');
        
        // Store current user ID as previous user for next login
        $response->cookie('previous_user_id', encrypt($currentUserId), 60 * 24, '/', null, true, true);
        
        Log::info('✅ LOGOUT COMPLETE - PREVIOUS USER ID STORED IN COOKIE', [
            'user_id_for_next_login' => $currentUserId
        ]);
        
        return $response;
    }

    /**
     * Username field
     */
    public function username()
    {
        return 'email';
    }
}