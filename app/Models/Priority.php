<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Priority extends Model
{
    use SoftDeletes;

    public $table = 'priority';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'active',
        'sla',
        'company_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'priority_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
