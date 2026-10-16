<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class SsoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $encryptedUserId = $request->cookie('user_id');
        $authToken = $request->cookie('auth_token');

        try {
            $userId = $encryptedUserId ? decrypt($encryptedUserId) : null;
        } catch (\Throwable $exception) {
            $userId = null;
        }

        $user = $userId && $authToken ? User::find($userId) : null;
        $tokenHash = $authToken ? hash('sha256', $authToken) : '';

        if (!$user || !$user->sso_token || !hash_equals($user->sso_token, $tokenHash)) {
            Auth::logout();

            return redirect()->guest(route('login'))
                ->withCookie(cookie()->forget('user_id'))
                ->withCookie(cookie()->forget('auth_token'));
        }

        Auth::login($user);
        $request->attributes->set('tenant_company_id', $user->company_id);
        $request->attributes->set('tenant_platform_admin', (int) $user->company_id === 0);

        return $next($request);
    }
}
