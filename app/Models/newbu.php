<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class newbu extends Model
{
    use SoftDeletes;

    protected $table = 'business_units';

    protected $fillable = [
        'company_id','bu_user', 'name', 'email',
        'phone', 'alternate_phone', 'address_1',
        'address_2', 'latitude', 'longitude', 'city',
        'state', 'country', 'zipcode', 'status',
        'vendor_r','parent_bu_id'
    ];

    // Other model configurations or relationships can be added here...

    use HasFactory;
}
    // app/Models/Ticket.php

