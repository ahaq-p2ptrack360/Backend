<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{


    public function login(Request $request)
    {
        // dd("");
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed'], 422);
        }

        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Generate API token if needed
        // // $token = $user->createToken('api-token')->plainTextToken;
        $status = $user->status;
        // dd()
        if ($status !== "0") {
            // Auth::logout(); // Logout user
            // dd("First logout from the last device");
            return redirect()->route('login')->with(['error' => 'logout from previous  device']);
        } else {

            // DB::table('users')->where('id', $user->id)->update(['status' => 1]);
            //
            $token = bin2hex(random_bytes(16)); // You can adjust the length as needed

            // Store the SSO token in the database
            DB::update('UPDATE users SET sso_token = ? , status = "1" where id = ? ', [
                $token, auth()->user()->id]);
            // auth()->user()->update(['sso_token' => $token]);

            // dd('authenticated method called'.auth()->user()->id);

            // Set the token as a cookie in the user's browser
            return redirect('/index')->cookie('sso_token', $token, 0, '/', '', false, true);
        }
        // else
        // {
        //     return response()->json($user);
        // }
    }

    public function login2(Request $request)
    {
        // dd("");
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed'], 422);
        }

        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Generate API token if needed
        // // $token = $user->createToken('api-token')->plainTextToken;
        // $status = $user->status;
        // // dd()
        // if ($status !== "0") {
        //     // Auth::logout(); // Logout user
        //     // dd("First logout from the last device");
        //     return redirect()->route('login')->with(['error' => 'logout from previous  device']);
        // } else {

        //     // DB::table('users')->where('id', $user->id)->update(['status' => 1]);
        //     //
        //     $token = bin2hex(random_bytes(16)); // You can adjust the length as needed

        //     // Store the SSO token in the database
        //     DB::update('UPDATE users SET sso_token = ? , status = "1" where id = ? ', [
        //         $token, auth()->user()->id]);
        //     // auth()->user()->update(['sso_token' => $token]);

        //     // dd('authenticated method called'.auth()->user()->id);

        //     // Set the token as a cookie in the user's browser
        //     return redirect('/index')->cookie('sso_token', $token, 0, '/', '', false, true);
        // }
        
        else
        {
            return response()->json($user);
        }
    }

    public function send_otp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);
        Cache::put('otp_' . $request->email, Hash::make($otp), now()->addMinutes(5));

        Mail::to($request->email)->send(new OtpMail($otp));
        // $value = Cache::get('otp_' . $request->email);
        // dd($value);
        return redirect('/otp/input')->with('email', $request->email);
    }

    public function verify_otp(Request $request) {
        $request->validate(['email' => 'required|email', 'otp' => 'required']);
    
        $storedOtp = Cache::get('otp_' . $request->email);
        if (!$storedOtp || !Hash::check($request->otp, $storedOtp)) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }
        DB::update('UPDATE `users` SET status = 0 where email = ? ', [
            $request->email]);                

        Cache::forget('otp_' . $request->email);

        return redirect('/login');
    }

}
