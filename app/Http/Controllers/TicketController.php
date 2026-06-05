<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Events\TicketCreatedNotification;  
use App\Events\TicketUpdatedNotification;  

class TicketController extends Controller
{
    public function index()
    {
        $tickets = DB::select('SELECT * FROM vw_tickets');
        return response()->json($tickets);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            
            // Validate required fields
            $requiredFields = [
                'title',
                'description', 
                'company_id',
                'business_unit_id',
                'reported_by',
                'assigned_to',
                'status_id',
                'created_by'
            ];
            
            $missingFields = [];
            foreach ($requiredFields as $field) {
                if (!isset($data[$field]) || $data[$field] === '') {
                    $missingFields[] = $field;
                }
            }
            
            if (!empty($missingFields)) {
                return response()->json([
                    'error' => 'Missing required fields',
                    'missing_fields' => $missingFields
                ], 400);
            }
            
            // Sanitize and prepare data
            $title = trim($data['title'] ?? '');
            $description = trim($data['description'] ?? '');
            $company_id = intval($data['company_id'] ?? 0);
            $business_unit_id = intval($data['business_unit_id'] ?? 0);
            $reported_by = intval($data['reported_by'] ?? 0);
            $assigned_to = intval($data['assigned_to'] ?? 0);
            $created_by = intval($data['created_by'] ?? 0);
            $status_id = intval($data['status_id'] ?? 0);
            $sub_type_id = intval($data['sub_type_id'] ?? 0);
            $priority_id = intval($data['priority_id'] ?? 0);
            $impact_id = intval($data['impact_id'] ?? 0);
            $customer_id = isset($data['customer_id']) && $data['customer_id'] !== '' ? intval($data['customer_id']) : 0;
            $vendor_id = isset($data['vendor_id']) && $data['vendor_id'] !== '' ? intval($data['vendor_id']) : 0;
            $vendor_type_id = isset($data['vendor_type_id']) && $data['vendor_type_id'] !== '' ? intval($data['vendor_type_id']) : 0;
            $completed_by = isset($data['completed_by']) && $data['completed_by'] !== '' ? intval($data['completed_by']) : 0;
            $mode_of_complaint = trim($data['mode_of_complaint'] ?? '');
            $store_contact = trim($data['store_contact'] ?? '');
            $completed_date = $data['completed_date'] ?? null;
            $due_date = $data['due_date'] ?? null;
            $email_status = isset($data['email_status']) ? intval($data['email_status']) : 0;
            $allow_quot = isset($data['allow_quot']) ? intval($data['allow_quot']) : 0;
            $assigned_type = trim($data['assigned_type'] ?? 'Individual');
            
            // Handle file upload
            $profilePath = null;
            if ($request->hasFile('profile')) {
                try {
                    $profilePath = $request->file('profile')->store('documents', 'public');
                    \Log::info('File uploaded successfully', ['path' => $profilePath]);
                } catch (\Exception $e) {
                    \Log::error('File upload failed: ' . $e->getMessage());
                }
            }
            
            // Insert ticket
            $insertId = DB::table('tickets')->insertGetId([
                'title' => $title,
                'description' => $description,
                'completed_date' => $completed_date,
                'due_date' => $due_date,
                'company_id' => $company_id,
                'completed_by' => $completed_by,
                'business_unit_id' => $business_unit_id,
                'customer_id' => $customer_id,
                'vendor_id' => $vendor_id,
                'vendor_type_id' => $vendor_type_id,
                'reported_by' => $reported_by,
                'assigned_to' => $assigned_to,
                'mode_of_complaint' => $mode_of_complaint,
                'sub_type_id' => $sub_type_id,
                'priority_id' => $priority_id,
                'impact_id' => $impact_id,
                'status_id' => $status_id,
                'store_contact' => $store_contact,
                'created_by' => $created_by,
                'email_status' => $email_status,
                'file' => $profilePath,
                'allow_qutation' => $allow_quot,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // 🔔 FIRE NOTIFICATION EVENT 🔔
            $createdByUser = DB::table('users')->where('id', $created_by)->first();
            $userName = $createdByUser->name ?? $createdByUser->first_name ?? 'A user';
            
            $ticketData = DB::table('tickets')->where('id', $insertId)->first();
            
            // Fire event with company_id
            event(new TicketCreatedNotification($ticketData, $userName, $company_id));
            
            $user = DB::table('users')->where('id', $created_by)->first();
            if ($user) {
                DB::table('ticket_activity')->insert([
                    'remarks' => "Ticket created by user " . ($user->name ?? $user->first_name ?? 'Unknown'),
                    'ticket_id' => $insertId,
                    'created_by' => $created_by,
                    'created_at' => now(),
                ]);
            }
            
            // Assign user/group
            if ($assigned_type == 'Individual') {
                DB::table('ticket_assigned_to')->insert([
                    'ticket_id' => $insertId,
                    'user_id' => $assigned_to,
                    'group_id' => 0,
                    'type' => 'Individual',
                    'created_at' => now(),
                ]);
            } else {
                DB::table('ticket_assigned_to')->insert([
                    'ticket_id' => $insertId,
                    'user_id' => 0,
                    'group_id' => $assigned_to,
                    'type' => 'Group',
                    'created_at' => now(),
                ]);
            }
            
            // Rest of your email code remains same...
            $ticketLink = url('/ticket');
            
            $sendEmail = function($email, $name, $subject, $body) {
                if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    \Log::warning('Invalid email address', ['email' => $email, 'name' => $name]);
                    return false;
                }
                
                try {
                    Mail::send([], [], function ($message) use ($email, $subject, $body) {
                        $message->to($email)
                            ->subject($subject)
                            ->setBody($body, 'text/html');
                    });
                    \Log::info('Email sent successfully', ['to' => $email]);
                    return true;
                } catch (\Exception $e) {
                    \Log::error('Email sending failed: ' . $e->getMessage(), ['email' => $email]);
                    return false;
                }
            };
            
            // Email to assigned user
            $assignedUser = DB::table('users')->where('id', $assigned_to)->first();
            if ($assignedUser) {
                $assignedUserName = $assignedUser->name ?? $assignedUser->first_name ?? 'User';
                $body = "Dear {$assignedUserName},<br><br>" .
                       "A new ticket has been assigned to you:<br><br>" .
                       "<strong>Title:</strong> {$title}<br><br>" .
                       "Click the button below to view the ticket:<br><br>" .
                       "<a href='{$ticketLink}' style='padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;'>View Ticket</a><br><br>" .
                       "Thanks.";
                       
                $sendEmail($assignedUser->email ?? '', $assignedUserName, 'New Ticket Assigned', $body);
            }
            
            // Email to customer
            if ($customer_id > 0) {
                $customer = DB::table('customers')->where('id', $customer_id)->first();
                if ($customer) {
                    $customerName = $customer->first_name ?? 'Customer';
                    $body = "Dear {$customerName},<br><br>" .
                           "A new ticket has been created for your request.<br><br>" .
                           "<strong>Title:</strong> {$title}<br><br>" .
                           "You can track the status by clicking the button below:<br><br>" .
                           "<a href='{$ticketLink}' style='padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;'>Track Ticket</a><br><br>" .
                           "Thanks.";
                           
                    $sendEmail($customer->email ?? '', $customerName, 'Ticket Created Notification', $body);
                }
            }
            
            if ($allow_quot == 1) {
                if ($vendor_id > 0) {
                    $vendor = DB::table('vendors')->where('id', $vendor_id)->first();
                    if ($vendor) {
                        $body = "Dear {$vendor->name},<br><br>" .
                               "You are requested to provide a quotation for the following ticket:<br><br>" .
                               "<strong>Title:</strong> {$title}<br><br>" .
                               "Click the button below to submit your quotation:<br><br>" .
                               "<a href='{$ticketLink}' style='padding: 10px 20px; background-color: #ffc107; color: black; text-decoration: none; border-radius: 5px;'>Submit Quotation</a><br><br>" .
                               "Thanks.";
                               
                        $sendEmail($vendor->email ?? '', $vendor->name, 'Quotation Request', $body);
                    }
                } else if ($sub_type_id > 0) {
                    $vendors = DB::table('vendors')->where('vendor_type_id', $sub_type_id)->get();
                    foreach ($vendors as $vendor) {
                        $body = "Dear {$vendor->name},<br><br>" .
                               "You are invited to provide a quotation for the ticket:<br><br>" .
                               "<strong>Title:</strong> {$title}<br><br>" .
                               "Click the button below to view and submit your quotation:<br><br>" .
                               "<a href='{$ticketLink}' style='padding: 10px 20px; background-color: #ffc107; color: black; text-decoration: none; border-radius: 5px;'>Quote Now</a><br><br>" .
                               "Thanks.";
                               
                        $sendEmail($vendor->email ?? '', $vendor->name, 'Quotation Request', $body);
                    }
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Ticket created successfully',
                'id' => $insertId,
                'assign' => $assigned_type,
            ], 201);
            
        } catch (\Exception $e) {
            \Log::error('Ticket creation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create ticket',
                'error' => $e->getMessage(),
                'debug' => env('APP_DEBUG') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    public function show($id)
    {
        $ticket = DB::select('SELECT * FROM vw_tickets WHERE id = ?', [$id]);
        return response()->json($ticket);
    }
    public function show_group($id)
    {
        $gu = DB::select('SELECT ug.title,u.id,ug.created_at
        FROM bu_group_members m
        INNER JOIN u_group ug
        ON m.group_id = ug.id
        INNER JOIN users u
        ON u.id = m.member_id
        WHERE ug.id=?', [$id]);
        return response()->json($gu);
    }
    public function bu_fields($id)
    {
        $ticket = DB::select('SELECT * FROM `bu_fields` WHERE bu_id=?', [$id]);
        return response()->json($ticket);
    }

    public function companywise($id)
    {
        $tickets = DB::select('SELECT * FROM vw_tickets WHERE company_id = ? and active=1', [$id]);
        
        // foreach($tickets as $ticket) {
        //     $quotations = DB::select('SELECT * FROM qoutations WHERE ticket_id = ?', [$ticket->id]);
        //     $ticket->quotations = $quotations;
        // }
        
        return response()->json($tickets);
    }

    public function ticket_activity($id)
    {
        $tickets = DB::select('SELECT * FROM ticket_activity where ticket_id = ?', [$id]);
        return response()->json($tickets);
    }

    // public function update(Request $request, $id)
    // {
    //     $data = $request->all();

    //     DB::update('UPDATE tickets SET title = ?, description = ?, completed_date = ?, due_date = ?,completed_by = ?, business_unit_id = ?,customer_id=?,  reported_by = ?, assigned_to = ?, mode_of_complaint = ?, sub_type_id = ?, priority_id = ?, impact_id = ?, status_id = ?, store_contact = ?WHERE id = ?',
    //         [$data['title'], $data['description'], $data['completed_date'], $data['due_date'], $data['completed_by'], $data['business_unit_id'], $data['customer_id'], $data['reported_by'], $data['assigned_to'], $data['mode_of_complaint'], $data['sub_type_id'], $data['priority_id'], $data['impact_id'], $data['status_id'], $data['store_contact'], $id]);
    //     $user = DB::select('select * from users where id=?', [$data['created_by']]);
    //     DB::insert('INSERT INTO `ticket_activity`(`remarks`,`ticket_id`, `created_by`)  VALUES ( ?, ?, ?)',
    //         ["Ticket update by user " . $user[0]->name, $id, $data['created_by']]);
    //     return response()->json(['message' => 'Ticket updated successfully']);
    // }
    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            
            // Get old ticket data before update
            $oldTicket = DB::table('tickets')->where('id', $id)->first();
            
            // 🔥 FIX DATE FORMAT ISSUE 🔥
            // Convert completed_date to YYYY-MM-DD format
            $completed_date = null;
            if (!empty($data['completed_date'])) {
                try {
                    $completed_date = date('Y-m-d', strtotime($data['completed_date']));
                } catch (\Exception $e) {
                    $completed_date = null;
                    \Log::warning('Date conversion failed', ['date' => $data['completed_date']]);
                }
            }
            
            // Convert due_date to YYYY-MM-DD format
            $due_date = null;
            if (!empty($data['due_date'])) {
                try {
                    $due_date = date('Y-m-d', strtotime($data['due_date']));
                } catch (\Exception $e) {
                    $due_date = null;
                    \Log::warning('Date conversion failed', ['date' => $data['due_date']]);
                }
            }
            
            // Update ticket with converted dates
            DB::update('UPDATE tickets SET title = ?, description = ?, completed_date = ?, due_date = ?, completed_by = ?, business_unit_id = ?, customer_id = ?, reported_by = ?, assigned_to = ?, mode_of_complaint = ?, sub_type_id = ?, priority_id = ?, impact_id = ?, status_id = ?, store_contact = ? WHERE id = ?',
                [
                    $data['title'], 
                    $data['description'], 
                    $completed_date,  // Converted date
                    $due_date,        // Converted date
                    $data['completed_by'], 
                    $data['business_unit_id'], 
                    $data['customer_id'], 
                    $data['reported_by'], 
                    $data['assigned_to'], 
                    $data['mode_of_complaint'], 
                    $data['sub_type_id'], 
                    $data['priority_id'], 
                    $data['impact_id'], 
                    $data['status_id'], 
                    $data['store_contact'], 
                    $id
                ]
            );
            
            // Get updated ticket data
            $updatedTicket = DB::table('tickets')->where('id', $id)->first();
            
            // Track what fields were changed
            $changedFields = [];
            $fieldLabels = [
                'title' => 'Title',
                'description' => 'Description',
                'status_id' => 'Status',
                'priority_id' => 'Priority',
                'assigned_to' => 'Assigned To',
                'due_date' => 'Due Date'
            ];
            
            foreach ($fieldLabels as $field => $label) {
                if ($oldTicket && isset($oldTicket->$field) && isset($updatedTicket->$field)) {
                    if ($oldTicket->$field != $updatedTicket->$field) {
                        $changedFields[] = $label;
                    }
                }
            }
            
            // Get user who performed the update
            $user = DB::table('users')->where('id', $data['created_by'])->first();
            $userName = $user->name ?? $user->first_name ?? 'A user';
            
            // 🔔 FIRE NOTIFICATION EVENT WITH COMPANY ID 🔔
            $companyId = $data['company_id'] ?? $oldTicket->company_id ?? null;
            event(new TicketUpdatedNotification($updatedTicket, $userName, $changedFields, $companyId));
            \Log::info('Ticket update notification fired', [
                'ticket_id' => $id, 
                'user' => $userName,
                'company_id' => $companyId
            ]);
            
            DB::insert('INSERT INTO `ticket_activity`(`remarks`, `ticket_id`, `created_by`) VALUES (?, ?, ?)',
                ["Ticket updated by user " . ($user->name ?? 'Unknown'), $id, $data['created_by']]);
            
            return response()->json(['message' => 'Ticket updated successfully']);
            
        } catch (\Exception $e) {
            \Log::error('Ticket update failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to update ticket', 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM tickets WHERE id = ?', [$id]);
        return response()->json(['message' => 'Ticket deleted successfully']);
    }

    public function saveactivity(Request $request)
    {
        $data = $request->all();

        DB::insert('INSERT INTO `ticket_activity`(`remarks`,`ticket_id`, `created_by`)  VALUES ( ?, ?, ?)',
            [$data['remarks'], $data['ticket_id'], $data['created_by']]);

        return response()->json(['message' => 'Ticket created successfully']);
    }

    public function updatevendor(Request $request, $id)
    {
        $data = $request->all();

        DB::update('UPDATE tickets SET vendor_id = ? WHERE id = ?',
            [$data['vendor_id'], $id]);

        return response()->json(['message' => 'Vendor updated successfully']);
    }

    public function saveqoutations(Request $request)
    {
        $data = $request->all();

        DB::insert('INSERT INTO `qoutations`(`company_id`,`ticket_id`, `vendor_id`,`amount`,`description`)  VALUES (?, ?, ?,?,?)',
            [$data['company_id'], $data['ticket_id'], $data['vendor_id'], $data['amount'], $data['remarks']]);

        return response()->json(['message' => 'Qutation created successfully']);
    }
    public function showQuotation($id)
    {
        $ticket = DB::select('SELECT * FROM `vw_quote` WHERE ticket_id = ?', [$id]);
        return response()->json($ticket);
    }
    public function updateqoutations(Request $request, $id)
    {
        $data = $request->all();

        DB::update('UPDATE qoutations SET approved_amount = ?, actual_amount = ? WHERE id = ?',
            [$data['approved_amount'], $data['actual_amount'], $id]);

        return response()->json(['message' => 'Amount updated successfully']);
    }

    public function updatestatus(Request $request)
    {
        $data = $request->all();

        DB::update('UPDATE `tickets` SET `status_id`=? WHERE id=?',
            [$data['status'], $data['id']]);

        return response()->json(['message' => 'Status updated successfully']);
    }

    public function updatetickstatus(Request $request)
    {
        $data = $request->all();
        DB::update('UPDATE tickets SET active = ? WHERE id = ?', [
            $data['active'],
            $data['id'],

        ]);
        return response()->json(['message' => 'Type status updated successfully']);
    }
    public function showticketbyvendor($id)
    {
        // Get the vendor by ID
        $vendors = DB::select('SELECT * FROM `vendors` v WHERE v.userId = ?', [$id]);

        // Check if vendor exists
        if (empty($vendors)) {
            return response()->json(['error' => 'Vendor not found'], 404);
        }

        // Get the first vendor
        $vendor = $vendors[0];

        // Now fetch tickets based on vendor_type_id
        $tickets = DB::select('SELECT
    t.*,
    q.id AS quote_id,
    q.amount
FROM vw_tickets t
LEFT JOIN qoutations q
    ON t.id = q.ticket_id AND q.vendor_id = ?
WHERE t.allow_qutation = 1
  AND t.sub_type_id = ?;', [$id, $vendor->vendor_type_id]);

        return response()->json($tickets);
    }
    public function ticket_reply(Request $request)
    {
        $data = $request->all();

        DB::insert('INSERT INTO `ticket_reply` (`message`, `ticket_id`, `created_by`) VALUES (?, ?, ?)', [
            $data['message'],
            $data['ticket_id'],
           $data['created_by'] // Hardcoded created_by = 0
        ]);

        return response()->json(['success' => 'Reply added successfully']);
    }

    public function get_ticket_reply($id)
    {
        $ticket = DB::select('
        SELECT tr.*, t.title ,u.first_name as name
        FROM `ticket_reply` tr
        JOIN tickets t ON tr.ticket_id = t.id
join users u on tr.created_by =u.id
        WHERE tr.ticket_id = ?
    ', [$id]);

        return response()->json($ticket);
    }

}
