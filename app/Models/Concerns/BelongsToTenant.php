<?php

namespace App\Models\Concerns;

use App\Models\Scopes\TenantCompanyScope;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        static::addGlobalScope(new TenantCompanyScope());

        static::creating(function ($model) {
            static::setAuthenticatedCompany($model);
        });

        static::updating(function ($model) {
            static::setAuthenticatedCompany($model);
        });
    }

    protected static function setAuthenticatedCompany($model)
    {
        $request = app('request');
        $companyId = $request->attributes->get('tenant_company_id');

        if ($companyId !== null && !$request->attributes->get('tenant_platform_admin')) {
            $model->setAttribute('company_id', $companyId);
        }
    }
}
