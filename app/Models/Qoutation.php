<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qoutation extends Model 
{
    use SoftDeletes;

    public $table = 'qoutations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'vendor_id',
        'company_id',
        'ticket_id',
        'amount',
        'approved',
        'description',
        'approved_by',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    
    public function tickets()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    
    public function created_users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

     public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
