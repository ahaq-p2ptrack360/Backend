<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class TicketActivity extends Model implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;

    public const STATUS_SELECT = [
        'active'        => 'Active',
        'hold'          => 'Hold',
        'completed'     => 'Completed',
    ];

    public $table = 'ticket_activity';

    protected $appends = [
        'image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'remarks',
        'status',
        'ticket_id',
        'assigned_to',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function tickets()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function assign_users()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function created_users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getCompletedDateAttribute($value)
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
