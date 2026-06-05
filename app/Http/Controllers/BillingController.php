<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BillingController extends Controller
{
    public function getCompanyBillingHistory($companyId)
    {
        try {

            // ================= COMPANY CHECK =================
            $company = Company::find($companyId);

            if (!$company) {
                return response()->json([
                    'status' => false,
                    'message' => 'Company not found'
                ], 404);
            }

            // ================= INVOICES + PAYMENTS =================
            $invoices = DB::table('invoices')
                ->leftJoin('payments', 'payments.invoice_id', '=', 'invoices.id')
                ->leftJoin('subscription_package', 'subscription_package.id', '=', 'payments.subscription_package_id')
                ->where('invoices.company_id', $companyId)
                ->select(
                    'invoices.id as invoice_id',
                    'invoices.invoice_number',
                    'invoices.project_name',
                    'invoices.amount',
                    'invoices.paid_amount',
                    'invoices.currency',
                    'invoices.status as invoice_status',
                    'invoices.invoice_date',
                    'invoices.due_date',

                    // Payment fields (safe defaults later)
                    'payments.payment_status',
                    'payments.payment_method',
                    'payments.transaction_id',
                    'payments.payment_date',
                    'payments.plan_name',
                    'payments.billing_cycle',

                    // Package
                    'subscription_package.active as package_active'
                )
                ->orderBy('invoices.created_at', 'desc')
                ->get()
                ->map(function ($item) {

                    return [
                        'invoice_id' => $item->invoice_id,
                        'invoice_number' => $item->invoice_number,
                        'project_name' => $item->project_name,
                        'amount' => (float) $item->amount,
                        'paid_amount' => (float) $item->paid_amount,
                        'currency' => $item->currency ?? 'USD',
                        'invoice_status' => $item->invoice_status,
                        'invoice_date' => $item->invoice_date,
                        'due_date' => $item->due_date,

                        // ✅ FIX: null handling
                        'payment_status' => $item->payment_status ?? 'unpaid',
                        'payment_method' => $item->payment_method ?? null,
                        'transaction_id' => $item->transaction_id ?? null,
                        'payment_date' => $item->payment_date,
                        'plan_name' => $item->plan_name ?? null,
                        'billing_cycle' => $item->billing_cycle ?? null,

                        // Package
                        'package_active' => (bool) $item->package_active,
                    ];
                });

            // ================= RESPONSE =================
            return response()->json([
                'status' => true,
                'company_id' => $companyId,   // ✅ FIXED (no pagination metadata)
                'data' => $invoices
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}