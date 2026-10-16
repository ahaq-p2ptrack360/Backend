<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Facades\Auth;

trait ScopesTenantCompanyData
{
    protected function tenantCompanyId($requestedCompanyId = null)
    {
        $user = Auth::user();

        if ($user && (int) $user->company_id !== 0) {
            return (int) $user->company_id;
        }

        return $requestedCompanyId;
    }

    protected function scopeVisibleCompanyData($query, $column = 'company_id')
    {
        $companyId = $this->tenantCompanyId();

        if ($companyId !== null && (int) $companyId !== 0) {
            $query->where(function ($nestedQuery) use ($column, $companyId) {
                $nestedQuery->where($column, $companyId)
                    ->orWhere($column, 0);
            });
        }

        return $query;
    }

    protected function scopeWritableCompanyData($query, $column = 'company_id')
    {
        $companyId = $this->tenantCompanyId();

        if ($companyId !== null && (int) $companyId !== 0) {
            $query->where($column, $companyId);
        }

        return $query;
    }
}