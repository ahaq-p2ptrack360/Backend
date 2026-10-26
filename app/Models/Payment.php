<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'company_id',
        'user_id',
        'invoice_id',
        'subscription_package_id',
        'plan_name',
        'billing_cycle',
        'amount',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'currency',
        'payment_method',
        'card_type',
        'card_last_four',
        'card_holder_name',
        'card_expiry_month',
        'card_expiry_year',
        'transaction_id',
        'payment_provider',
        'customer_email',
        'customer_phone',
        'billing_address',
        'shipping_address',
        'payment_status',
        'payment_date',
        'notes',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function subscriptionPackage()
    {
        return $this->belongsTo(SubscriptionPackage::class);
    }
}