<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class group_des extends Model
{
    use SoftDeletes;

    protected $table = 'group_designation';

    protected $fillable = [
        'bu_id', 'group_id', 'designation_id'
    ];

    // Other model configurations or relationships can be added here...

    use HasFactory;
}
    // app/Models/Ticket.php

