<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Company extends Model implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;
    use HasMediaTrait;
    public $table = 'company';

    protected $appends = [
        'companylogo',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'telephon',
        'mobile',
        'address_1',
        'address_2',
        'city_id',
        'state_id',
        'country_id',
        'zipcode',
        'status',
        'registration_number',
        'region',
        'first_name',
        'middle_name',
        'last_name',
        'website',
        'communication',
        'datalines',
        'telebox',
        'comments',
        'language',
        'domain_id',
        'licences',
        'latitude',
        'longitude',
        'support_email',
        'support_contact',
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

    public function getCompanyLogoAttribute()
    {
        $file = $this->getMedia('companylogo')->last();
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
    public function domain()
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }

    public function user_update()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getProfileUrlAttribute()
    {
        if (isset($this->profile) && $this->profile) {
            // ✅ Sirf filename extract karo
            $filename = basename($this->profile);
            return config('app.api_url') . 'companies/profile-image/' . $filename;
        }
        
        return null;
    }
}
