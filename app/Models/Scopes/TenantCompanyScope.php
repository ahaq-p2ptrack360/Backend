<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantCompanyScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $request = app('request');
        $companyId = $request->attributes->get('tenant_company_id');

        // Company 0 is the application's existing platform-administrator tenant.
        if (!$request->attributes->has('tenant_company_id') || $request->attributes->get('tenant_platform_admin')) {
            return;
        }

        if ((int) $companyId === 0) {
            return;
        }

        if ($companyId === null || $companyId === '') {
            $builder->whereRaw('1 = 0');
            return;
        }

        $builder->where($model->qualifyColumn('company_id'), $companyId);
    }
}
