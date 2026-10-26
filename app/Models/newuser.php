<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class newuser extends Model
{
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'first_name', 'last_name',
        'company_id', 'bu_id', 'designation_id',
        'name', 'email',
        'password','two_factor_secret', 'about',  'photo_url','role','type'
    ];

    // Other model configurations or relationships can be added here...

    use HasFactory;
}
    // app/Models/Ticket.php

