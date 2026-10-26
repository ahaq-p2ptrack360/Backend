<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group1 extends Model
{
    use SoftDeletes;

    public $table = 'bu_group';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'bu_id',
        'default_group',
        'company_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function bu()
    {
        return $this->belongsTo(BusinessUnit::class, 'bu_id');
    }

    public function members()
    {
        return $this->hasMany(GroupMember::class, 'group_id', 'id');
    }
}
