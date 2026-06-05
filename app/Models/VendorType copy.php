<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorType extends Model
{
    use SoftDeletes;

    public $table = 'types';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'parent_id',
        'active',
        'company_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function parentTypes()
    {
        return $this->hasMany(VendorType::class, 'parent_id', 'id');
    }

    

    public function typeVendors()
    {
        return $this->belongsToMany(Vendor::class);
    }

    public function parent()
    {
        return $this->belongsTo(VendorType::class, 'parent_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
