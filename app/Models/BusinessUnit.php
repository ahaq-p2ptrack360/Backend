<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class BusinessUnit extends Model implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;

    public $table = 'business_units';

    protected $appends = [
        'image',
    ];
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'vendortype',
        'marketing_manager',
        'store_manager',
        'company_id',
        'name',
        'email',
        'phone',
        'alternate_phone',
        'address_1',
        'address_2',
        'city',
        'state',
        'country',
        'zipcode',
        'status',
        'latitude',
        'longitude',
        'created_by ',
        'bu_user',
        'updated_by ',
        'created_at ',
        'updated_at ',
        'deleted_at ',
        'properties ',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getImageAttribute()
    {
        $file = $this->getMedia('image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function storemanager()
    {
        return $this->belongsTo(User::class, 'store_manager');
    }

    public function marketingManager()
    {
        return $this->belongsTo(User::class, 'marketing_manager');
    }

    public function buUser()
    {
        return $this->belongsTo(User::class, 'bu_user');
    }

    public function user_update()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function vendor_type()
    {
        return $this->belongsTo(VendorType::class, 'vendortype');
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
