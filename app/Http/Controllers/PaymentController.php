<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Process payment and save to database
     */
    public function processPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact' => 'required',
            'payment_method' => 'required|in:credit_card,debit_card,paypal',
            'company_id' => 'required|numeric',
            'subscription_package_id' => 'nullable|numeric',
            'invoice_id' => 'nullable|numeric',
            'plan' => 'required|array',
            'plan.name' => 'required',
            'plan.billing_cycle' => 'required|in:monthly,annual',
            'plan.selected_price' => 'required|numeric',
            'amounts' => 'required|array',
            'amounts.subtotal' => 'required|numeric',
            'amounts.tax' => 'required|numeric',
            'amounts.total' => 'required|numeric',
            'currency' => 'nullable|string|size:3',
            'billing_address' => 'nullable|string',
            'shipping_address' => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            DB::beginTransaction();
    
            // ================= CARD PROCESS =================
            $cardLastFour = null;
            $cardType = null;
            $expiryMonth = null;
            $expiryYear = null;
    
            if (in_array($request->payment_method, ['credit_card', 'debit_card'])) {
    
                $cardNumber = preg_replace('/\s+/', '', $request->card['number']);
                $cardLastFour = substr($cardNumber, -4);
                $cardType = $this->detectCardType($cardNumber);
    
                if (!empty($request->card['expiry']) && strpos($request->card['expiry'], '/') !== false) {
                    [$expiryMonth, $expiryYear] = explode('/', $request->card['expiry']);
    
                    $expiryMonth = trim($expiryMonth);
                    $expiryYear = trim($expiryYear);
    
                    if (strlen($expiryYear) == 2) {
                        $expiryYear = '20' . $expiryYear;
                    }
                }
            }
    
            // ================= TRANSACTION =================
            $transactionId = 'TXN_' . strtoupper(uniqid()) . '_' . time();
    
            $userId = auth()->check() ? auth()->id() : null;
            $isEmail = filter_var($request->contact, FILTER_VALIDATE_EMAIL);
    
            // ================= 🔥 FIX: INVOICE RESOLUTION =================
            $invoiceId = $request->invoice_id;
    
            if (!$invoiceId) {
                $invoice = Invoice::where('company_id', $request->company_id)
                    ->whereIn('status', ['pending', 'overdue'])
                    ->latest()
                    ->first();
    
                if ($invoice) {
                    $invoiceId = $invoice->id;
                }
            }
    
            if (!$invoiceId) {
                return response()->json([
                    'success' => false,
                    'message' => 'No invoice found for this payment'
                ], 422);
            }
    
            // ================= PAYMENT CREATE =================
            $payment = Payment::create([
                'company_id' => $request->company_id,
                'user_id' => $userId,
    
                // 🔥 FIXED
                'invoice_id' => $invoiceId,
    
                'subscription_package_id' => $request->subscription_package_id,
                'plan_name' => $request->plan['name'],
                'billing_cycle' => $request->plan['billing_cycle'],
    
                'amount' => $request->amounts['subtotal'],
                'tax_amount' => $request->amounts['tax'],
                'discount_amount' => $request->plan['discount'] ?? 0,
                'total_amount' => $request->amounts['total'],
                'currency' => $request->currency ?? 'USD',
    
                'payment_method' => $request->payment_method,
                'card_type' => $cardType,
                'card_last_four' => $cardLastFour,
                'card_holder_name' => $request->card['holder'] ?? null,
                'card_expiry_month' => $expiryMonth,
                'card_expiry_year' => $expiryYear,
    
                'transaction_id' => $transactionId,
                'payment_provider' => $request->payment_method === 'paypal' ? 'paypal' : 'stripe',
    
                'customer_email' => $isEmail ? $request->contact : null,
                'customer_phone' => !$isEmail ? $request->contact : null,
    
                'billing_address' => $request->billing_address,
                'shipping_address' => $request->use_shipping_address
                    ? $request->billing_address
                    : $request->shipping_address,
    
                'payment_status' => 'completed',
                'payment_date' => now(),
    
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'notes' => $request->notes ?? null
            ]);
    
            // ================= 🔥 FIX: UPDATE INVOICE =================
            Invoice::where('id', $invoiceId)->update([
                'status' => 'paid',
                'paid_amount' => $request->amounts['total']
            ]);
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Payment processed successfully',
                'data' => [
                    'id' => $payment->id,
                    'invoice_id' => $invoiceId,
                    'transaction_id' => $payment->transaction_id,
                    'total_amount' => $payment->total_amount,
                    'payment_status' => $payment->payment_status,
                    'payment_date' => $payment->payment_date
                ]
            ], 201);
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json([
                'success' => false,
                'message' => 'Payment processing failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single payment
     */
    public function getPayment($id)
    {
        $payment = Payment::with(['company', 'user', 'invoice', 'subscriptionPackage'])->find($id);
        
        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $payment
        ]);
    }

    /**
     * Get company payments
     */
    public function getCompanyPayments($companyId)
    {
        $payments = Payment::where('company_id', $companyId)
                          ->with(['user', 'subscriptionPackage'])
                          ->orderBy('created_at', 'desc')
                          ->get();

        return response()->json([
            'success' => true,
            'data' => $payments
        ]);
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'payment_status' => 'required|in:pending,processing,completed,failed,refunded,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $payment = Payment::find($id);
        
        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found'
            ], 404);
        }

        $payment->payment_status = $request->payment_status;
        $payment->save();

        return response()->json([
            'success' => true,
            'message' => 'Payment status updated successfully',
            'data' => $payment
        ]);
    }

    /**
     * Detect card type
     */
    private function detectCardType($cardNumber)
    {
        $cardNumber = preg_replace('/\s+/', '', $cardNumber);
        
        if (preg_match('/^4/', $cardNumber)) {
            return 'visa';
        } elseif (preg_match('/^5[1-5]/', $cardNumber)) {
            return 'mastercard';
        } elseif (preg_match('/^3[47]/', $cardNumber)) {
            return 'amex';
        } elseif (preg_match('/^6(?:011|5)/', $cardNumber)) {
            return 'discover';
        } elseif (preg_match('/^35/', $cardNumber)) {
            return 'jcb';
        } elseif (preg_match('/^30[0-5]|36|38|39/', $cardNumber)) {
            return 'diners';
        } else {
            return 'unknown';
        }
    }
}