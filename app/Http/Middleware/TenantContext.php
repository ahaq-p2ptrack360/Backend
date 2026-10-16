<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantContext
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $request->attributes->set('tenant_company_id', $user->company_id);
            $request->attributes->set('tenant_platform_admin', (int) $user->company_id === 0);

            // Body/query values must never select the actor. Tenant users are
            // likewise pinned to their authenticated company.
            $request->merge([
                'user_id' => $user->id,
                'created_by' => $user->id,
                'generated_by' => $user->id,
            ]);

            if ((int) $user->company_id !== 0) {
                $request->merge(['company_id' => $user->company_id]);

                // Normalize explicitly named tenant/actor path parameters too.
                foreach (['companyId', 'company_id', 'c_id', 'cid'] as $parameter) {
                    if ($request->route() && $request->route()->parameter($parameter) !== null) {
                        $request->route()->setParameter($parameter, $user->company_id);
                    }
                }
                if ($request->route() && strpos($request->route()->uri(), 'company') !== false
                    && $request->route()->parameter('id') !== null) {
                    $request->route()->setParameter('id', $user->company_id);
                }
                foreach (['user_id', 'u_id'] as $parameter) {
                    if ($request->route() && $request->route()->parameter($parameter) !== null) {
                        $request->route()->setParameter($parameter, $user->id);
                    }
                }
            }
        }

        return $next($request);
    }
}
