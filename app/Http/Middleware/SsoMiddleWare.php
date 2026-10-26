<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SsoMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->cookie('sso_token');

        if ($token) {
            // Authenticate the user using the token
            $user = User::where('sso_token', $token)->first();
            //dd($user);    
            if ($user) {
                Auth::login($user);
            }
        }

        return $next($request);
    }
}
