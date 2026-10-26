<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Vendor extends Model implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;

    public $table = 'vendors';

    protected $appends = [
        'image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'company_id',
        'vendor_type_id',
        // 'vendor_sub_type',
        'email',
        'phone',
        'alternate_phone',
        'latitude',
        'longitude',
        'address_1',
        'address_2',
        'city',
        'state',
        'country',
        'zipcode',
        'status',
        'created_by ',
        'updated_by ',
        'created_at ',
        'updated_at ',
        'deleted_at ',
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

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*public function sites()
    {
        return $this->belongsToMany(Site::class);
    }*/

    public function types()
    {
        return $this->belongsToMany(VendorType::class);
    }

    public function type()
    {
        return $this->belongsTo(VendorType::class, 'vendor_type_id');
    }

    public function user_update()
    {
        return $this->belongsTo(User::class, 'updated_by');
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
