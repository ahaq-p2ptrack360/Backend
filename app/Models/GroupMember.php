<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class GroupMember extends Model
{
    // use SoftDeletes;

    public $table = 'bu_group_members';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'group_id',
        'member_id',
        'created_at',
        'updated_at',
    ];

    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
