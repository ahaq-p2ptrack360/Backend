<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPackage extends Model
{
    protected $table = 'subscription_packages';
    
    protected $fillable = [
        'title',
        'price',
        'no_of_licence',
        'storage',
        'description',
        'active',
        'created_at',
        'updated_at'
    ];
}