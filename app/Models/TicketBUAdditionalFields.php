<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class TicketBUAdditionalFields extends Model
{
    // use SoftDeletes;

    public $table = 'ticket_bu_level_fields';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'ticket_id',
        'field',
        'type',
        'value',
        'required_status',
        'company_id',
        'created_at',
        'updated_at',
        // 'deleted_at',
    ];

    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
