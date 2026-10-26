<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class TicketHistory extends Model implements HasMedia
{
    // use SoftDeletes;
    use HasMediaTrait;

    public const PRIORITY = [
        'high'        => 'High',
        'medium'      => 'Medium',
        'low'         => 'Low',
    ];

    public $table = 'ticket_history';

    protected $appends = [
        'image',
    ];

    protected $dates = [
        'completed_date',
        'due_date',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'ticket_tbl_id',
        'ticketID',
        'type',
        'title',
        'description',
        'completed_date',
        'due_date',
        'vendor_type_id',
        'business_unit_id',
        'vendor_id',
        'company_id',
        'completed_by',
        'reported_by',
        'assigned_to',
        'mode_of_complaint',
        'sub_type_id',
        'status',
        'store_contact',
        'created_by',
        'created_at',
        'updated_at',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function vendors()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function vendor_type()
    {
        return $this->belongsTo(VendorType::class, 'vendor_type_id');
    }

    public function business_unit()
    {
        return $this->belongsTo(BusinessUnit::class, 'business_unit_id');
    }

    public function getCompletedDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }
    public function getDueDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setCompletedDateAttribute($value)
    {
        $this->attributes['completed_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
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
}
