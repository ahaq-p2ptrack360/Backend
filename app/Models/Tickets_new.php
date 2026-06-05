<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Tickets_new extends Model
{
    use SoftDeletes;

    protected $table = 'tickets';

    protected $fillable = [
        'external_id', 'ticketID', 'ticket_counter', 'title', 'description',
        'completed_date', 'due_date', 'company_id', 'completed_by',
        'business_unit_id', 'vendor_id', 'vendor_type_id', 'reported_by',
        'assigned_to', 'mode_of_complaint', 'sub_type_id', 'priority_id',
        'impact_id', 'status_id', 'file', 'store_contact', 'created_by',
        'created_at', 'updated_at', 'deleted_at', 'email_status',
    ];

    // Other model configurations or relationships can be added here...

    use HasFactory;
}
    // app/Models/Ticket.php

