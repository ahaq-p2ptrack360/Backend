<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
class DashboardController extends Controller
{

    public function index($c_id, $group, $bu_id, $user_id)
    {
        $principal = Auth::user();
        if ($principal && (int) $principal->company_id !== 0) {
            $c_id = $principal->company_id;
            $bu_id = $principal->bu_id;
            $user_id = $principal->id;
        }

        if ($group == 'Manager') {

            $bu_ids = DB::select("SELECT GROUP_CONCAT(id SEPARATOR ', ') as ids FROM `business_units` where parent_bu_id = ? and active=1", [$bu_id]);
            if ($bu_ids[0]->ids == null) {
                $all_bus = $bu_id;
            } else {
                $all_bus = $bu_ids[0]->ids . ', ' . $bu_id;
            }

            $businessUnitIds = array_map('intval', array_filter(explode(',', (string) $all_bus), 'strlen'));
            $total_tickets = DB::table('vw_tickets')
                ->where('company_id', $c_id)
                ->whereIn('business_unit_id', $businessUnitIds)
                ->where('active', 1)
                ->get();
            return response()->json($total_tickets);
        } else {
            $total_tickets = DB::select("SELECT * FROM `vw_tickets` where company_id = ? and business_unit_id = ? and (created_by = ? or assigned_to = ? and active=1)", [$c_id, $bu_id, $user_id, $user_id]);
            return response()->json($total_tickets);
        }
    }

    // public function getallickets($id)
    // {

    //     $groups = DB::select("SELECT GROUP_CONCAT(member_id) as members from bu_group_members where user_id =?;",[$id]);

    //     if ($groups[0]->members != null ) {

           
    //         return response()->json($total_tickets);
    //     } else {
    //         $total_tickets = DB::select("SELECT * FROM `tickets` where created_by = ?", [$id]);
    //         return response()->json($total_tickets);
    //     }
    // }

// public function getallickets($id)
// {
//     // admin check
//     $user = DB::table('users')->where('id', $id)->first(['company_id', 'id']);

//     if ($user && ($user->company_id == 0 || $user->id == 1)) {
//         $total_tickets = DB::select("SELECT * FROM tickets");
//         return response()->json($total_tickets);
//     }

//     // existing code same
//     $groups = DB::select("SELECT GROUP_CONCAT(member_id) as members from bu_group_members where user_id =?;",[$id]);

//     if (!empty($groups) && $groups[0]->members != null ) {

       
//         return response()->json($total_tickets);

//     } else {

//         $total_tickets = DB::select("SELECT * FROM tickets where created_by = ?", [$id]);
//         return response()->json($total_tickets);

//     }
// }

public function getallickets($id)
{
    $principal = Auth::user();
    if ($principal && (int) $principal->company_id !== 0) {
        $id = $principal->id;
    }

    $user = DB::table('users')->where('id', $id)->first(['company_id', 'id']);
    
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }
    
    // Super Admin 
    if ($principal && (int) $principal->company_id === 0) {
        $total_tickets = DB::select("
            SELECT t.*, 
                   s.title as status_title,
                   p.title as priority_title,
                   i.title as impact_title,
                   u.first_name as created_byfname,
                   u.last_name as created_bylname,
                   ru.first_name as reported_byfname,
                   ru.last_name as reported_bylname,
                   bu.name as bu_name,        
                   ty.title as type_title,
                   c.name as company_name
            FROM tickets t
            LEFT JOIN status s ON t.status_id = s.id
            LEFT JOIN priority p ON t.priority_id = p.id
            LEFT JOIN impacts i ON t.impact_id = i.id
            LEFT JOIN users u ON t.created_by = u.id
            LEFT JOIN users ru ON t.reported_by = ru.id
            LEFT JOIN business_units bu ON t.business_unit_id = bu.id
            LEFT JOIN types ty ON t.sub_type_id = ty.id
            LEFT JOIN company c ON t.company_id = c.id
            WHERE t.deleted_at IS NULL
        ");
        return response()->json($total_tickets);
    }
    
    $total_tickets = DB::select("SELECT t.*, 
               s.title as status_title,
               p.title as priority_title,
               i.title as impact_title,
               u.first_name as created_byfname,
               u.last_name as created_bylname,
               ru.first_name as reported_byfname,
               ru.last_name as reported_bylname,
               bu.name as bu_name,
               ty.title as type_title,
               c.name as company_name
        FROM tickets t
        LEFT JOIN status s ON t.status_id = s.id
        LEFT JOIN priority p ON t.priority_id = p.id
        LEFT JOIN impacts i ON t.impact_id = i.id
        LEFT JOIN users u ON t.created_by = u.id
        LEFT JOIN users ru ON t.reported_by = ru.id
        LEFT JOIN business_units bu ON t.business_unit_id = bu.id
        LEFT JOIN types ty ON t.sub_type_id = ty.id
        LEFT JOIN company c ON t.company_id = c.id
        WHERE t.deleted_at IS NULL
        AND t.company_id = ?", [$user->company_id]);
    
    return response()->json($total_tickets);
}


    public function get_customers_wise_t($c_id, $bu_id, $cus_id)
    {
        $c_id = $this->tenantCompanyId($c_id);
        $total_tickets = DB::select("SELECT * FROM `vw_tickets` WHERE company_id=? and business_unit_id =? and cus_id =? and active=1", [$c_id, $bu_id, $cus_id]);
        return response()->json($total_tickets);
    }
    public function get_customers($c_id)
    {
        $companyId = $this->tenantCompanyId(null);
        $sql = 'SELECT * FROM `customers` WHERE bu_id = ?';
        $bindings = [$c_id];
        if ($companyId !== null) {
            $sql .= ' AND company_id = ?';
            $bindings[] = $companyId;
        }
        $total_tickets = DB::select($sql, $bindings);
        return response()->json($total_tickets);
    }

    public function company_wise_dashboard($c_id)
    {
        $c_id = $this->tenantCompanyId($c_id);
        $total_tickets = DB::select("SELECT * FROM `vw_tickets` where company_id = ? and active=1", [$c_id]);
        return response()->json($total_tickets);
    }
    public function created_by_t($u_id,$id)
    {   
        $user = Auth::user();
        if ($user && (int) $user->company_id !== 0) {
            $u_id = $user->id;
        }
        $companyId = $this->tenantCompanyId(null);
        $companyClause = $companyId === null ? '' : ' AND company_id = ?';
        if($id == 1){
        $total_tickets = DB::select("SELECT * FROM `vw_tickets` WHERE reported_by = ? and active=1" . $companyClause, $companyId === null ? [$u_id] : [$u_id, $companyId]);
        return response()->json($total_tickets);
        }else if ($id == 2){
            $total_tickets = DB::select("SELECT * FROM `vw_tickets` WHERE assigned_to =? and active=1" . $companyClause, $companyId === null ? [$u_id] : [$u_id, $companyId]);
            return response()->json($total_tickets);
        }else{
            $sql = 'SELECT * FROM `vw_tickets` WHERE active=1' . $companyClause;
            $total_tickets = DB::select($sql, $companyId === null ? [] : [$companyId]);
            return response()->json($total_tickets); 
        }
    }
    public function assign_to_me($u_id)
    {
        $u_id = Auth::id();
        $total_tickets = DB::select("SELECT * FROM `vw_tickets` WHERE assigned_to =? and active=1", [$u_id]);
        return response()->json($total_tickets);
    }


    public function super_admin_tickets()
    {
        $companyId = $this->tenantCompanyId(null);
        $sql = 'SELECT * FROM vw_tickets where active=1';
        $bindings = [];
        if ($companyId !== null) {
            $sql .= ' AND company_id = ?';
            $bindings[] = $companyId;
        }
        $total_tickets = DB::select($sql, $bindings);
        return response()->json($total_tickets);
    }
    public function buwise_records($c_id, $bu_id)
    {
        $c_id = $this->tenantCompanyId($c_id);
        $total_tickets = DB::select('SELECT * FROM `vw_tickets` WHERE company_id =? AND business_unit_id =? and active=1', [$c_id, $bu_id]);
        return response()->json($total_tickets);
    }

    public function totaltickets($c_id, $from, $to)
    {
        $c_id = $this->tenantCompanyId($c_id);

        $total_tickets = DB::select("SELECT count(*) as total_tickets FROM `vw_tickets` where company_id = ? and created_at>=? and created_at <=? and active=1;", [$c_id, $from, $to]);
        return response()->json($total_tickets);
    }

    public function save_view(Request $request, $id) {
        $object = $request->all();
        $id = (int) $id;
                //    dd($object);
//    $object = [
//     (object)[
//         "id" => "130",
//         "vname" => null,
//         "resolved_name" => "Yahya_Shahzad_8386",
//         "file" => "documents/tbsvI8gMBWfOstq6ylvPCy9HDFgrhJ8KzsFc0VgK.jpg",
//         "company_name" => "Yahya Garments",
//         "external_id" => null,
//         "ticketID" => null,
//         "ticket_counter" => null,
//         "title" => "Check",
//         "description" => "desc",
//         "completed_date" => "2024-01-18",
//         "due_date" => "2024-01-18",
//         "company_id" => "120",
//         "completed_by" => "61",
//         "business_unit_id" => "145",
//         "vendor_id" => "0",
//         "vendor_type_id" => "0",
//         "reported_by" => "61",
//         "assigned_to" => "61",
//         "mode_of_complaint" => "High",
//         "sub_type_id" => "91",
//         "priority_id" => "76",
//         "impact_id" => "164",
//         "status_id" => "201",
//         "store_contact" => "P2P",
//         "created_by" => "61",
//         "created_at" => "2024-01-17 12:45:46",
//         "updated_at" => null,
//         "deleted_at" => null,
//         "email_status" => "0",
//         "bu_name" => "HQ Yahya Garments",
//         "vendor_r" => "yes",
//         "reported_by_name" => "Yahya_Shahzad_8386",
//         "type_title" => "Bug",
//         "status_title" => "Open",
//         "priority_title" => "Low",
//         "impact_title" => "Low",
//         "cus_id" => "3",
//         "fname" => "Waqas",
//         "lname" => "Ahmed",
//         "year" => "2024",
//         "month" => "1",
//         "day" => "17",
//         "bu_field_name" => null,
//         "Text" => null,
//         "F1" => null,
//         "Number" => null,
//         "view_id" => 682.5827450653996,
//         "view_name" => "Priority Low"
//     ],
//     (object)[
//         "id" => "131",
//         "vname" => null,
//         "resolved_name" => "ali_shahzad",
//         "file" => "documents/oa6DL9kU1ZDjiL9GRLa9CjFWxCeNjaUMQYttyqtf.jpg",
//         "company_name" => "Yahya Garments",
//         "external_id" => null,
//         "ticketID" => null,
//         "ticket_counter" => null,
//         "title" => "New Check",
//         "description" => "desc",
//         "completed_date" => "2024-01-19",
//         "due_date" => "2024-01-19",
//         "company_id" => "120",
//         "completed_by" => "62",
//         "business_unit_id" => "145",
//         "vendor_id" => "0",
//         "vendor_type_id" => "0",
//         "reported_by" => "61",
//         "assigned_to" => "61",
//         "mode_of_complaint" => "High",
//         "sub_type_id" => "91",
//         "priority_id" => "76",
//         "impact_id" => "164",
//         "status_id" => "201",
//         "store_contact" => "P2P",
//         "created_by" => "61",
//         "created_at" => "2024-01-18 10:50:51",
//         "updated_at" => null,
//         "deleted_at" => null,
//         "email_status" => "0",
//         "bu_name" => "HQ Yahya Garments",
//         "vendor_r" => "yes",
//         "reported_by_name" => "Yahya_Shahzad_8386",
//         "type_title" => "Bug",
//         "status_title" => "Open",
//         "priority_title" => "Low",
//         "impact_title" => "Low",
//         "cus_id" => "3",
//         "fname" => "Waqas",
//         "lname" => "Ahmed",
//         "year" => "2024",
//         "month" => "1",
//         "day" => "18",
//         "bu_field_name" => null,
//         "Text" => null,
//         "F1" => null,
//         "Number" => null,
//         "view_id" => 682.5827450653996,
//         "view_name" => "Priority Low"
//     ]
// ];

    try {
        DB::table('tickets_filter')->insert([
            'data' => json_encode($object),
            'created_by' => $id,
            'view_name' => $object[0]["view_name"]
        ]);     
            return response()->json(["success" => 1], 200);       
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);       
        }

    }

    public function retrieve_view($v_id) {
        $v_id = (int)$v_id;    
        $results = DB::Select("Select * from `tickets_filter` tf where tf.id = ?", [$v_id]);
         return response()->json($results);

    }

    public function retrieve_views($u_id) {
        $results = DB::Select("SELECT DISTINCT tf.id as  view_id, tf.view_name FROM `tickets_filter` tf where `created_by` = ? ", [$u_id]);
          return response()->json($results);
  
    }


    public function logout(Request $request, $id)
    {

        try {

                DB::update('UPDATE `users` SET status = 0 where id = ? ', [
                    $id]);                
                     
            Auth::logout(); 
            return redirect('/login')->withCookie(Cookie::forget('sso_token', '/', '', false, true)); 
        
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        }



    public function totalticketscompany_wise($c_id)
    {
        $c_id = $this->tenantCompanyId($c_id);

        try {

            $total_tickets = DB::select('CALL GetDynamicTickets(?)', [$c_id]);
            return response()->json($total_tickets, 200);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        } 
        }



    public function pendingtickets($c_id, $from, $to)
    {

        $pending_tickets = DB::select("SELECT count(*) as pending_tickets FROM `vw_tickets` where company_id = ? and status_title = 'Open' and created_at>=? and created_at <=? and active=1;", [$c_id, $from, $to]);
        return response()->json($pending_tickets);
    }
    public function inprogresstickets($c_id, $from, $to)
    {

        $inprogress_tickets = DB::select("SELECT count(*) as inprogress FROM `vw_tickets` where company_id = ? and status_title = 'In Progress' and created_at>=? and created_at <=? and active=1;", [$c_id, $from, $to]);
        return response()->json($inprogress_tickets);
    }

    public function closedtickets($c_id, $from, $to)
    {

        $inprogress_tickets = DB::select("SELECT count(*) as closed FROM `vw_tickets` where company_id = ? and status_title = 'Closed' and created_at>=? and created_at <=? and active=1;", [$c_id, $from, $to]);
        return response()->json($inprogress_tickets);
    }
    public function alltickets($c_id, $from, $to)
    {

        $alltickets = DB::select("SELECT *  FROM `vw_tickets` where company_id = ?  and created_at>=? and created_at <=? and active=1;", [$c_id, $from, $to]);
        return response()->json($alltickets);
    }
    public function impactgraph($c_id, $from, $to)
    {

        $impactgraph = DB::select("SELECT count(*) as ticket,impact_title FROM `vw_tickets` where company_id = ? and created_at >= ? and created_at <= ? and active=1 group by impact_id;", [$c_id, $from, $to]);
        return response()->json($impactgraph);
    }
    public function priority_graph($c_id, $from, $to)
    {

        $priority_graph = DB::select("SELECT count(*) as ticket,priority_title FROM `vw_tickets` where company_id = ? and created_at >= ? and created_at <= ? and active=1 group by priority_id;", [$c_id, $from, $to]);
        return response()->json($priority_graph);
    }
    public function yearly_graph($c_id)
    {

        $yearly_graph = DB::select("SELECT `months`.`Month` AS `Month`, COALESCE(COUNT(tickets.created_at), 0) AS `TicketCount` FROM ( SELECT 1 AS `Month` UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12 ) AS Months LEFT JOIN vw_tickets tickets ON MONTH(tickets.created_at) = Months.`Month` AND YEAR(tickets.created_at) = YEAR(CURDATE()) AND tickets.company_id = ? GROUP BY Months.`Month` ORDER BY Months.`Month`;", [$c_id]);
        return response()->json($yearly_graph);
    }

    public function notifyemail($id, $tid)
    {
        $principal = Auth::user();
        if (!$principal) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        $ticketQuery = DB::table('vw_tickets')->where('id', $tid);
        $userQuery = DB::table('users')->where('id', $id);
        if ((int) $principal->company_id !== 0) {
            $ticketQuery->where('company_id', $principal->company_id);
            $userQuery->where('company_id', $principal->company_id);
        }
        $ticket = $ticketQuery->first();
        $recipient = $userQuery->first();
        if (!$ticket || !$recipient || (int) $ticket->company_id !== (int) $recipient->company_id) {
            return response()->json(['message' => 'Ticket or recipient not found'], 404);
        }

        $user_email = $recipient->about;


        $data = [
            'name' => $ticket->title,
            'description' => $ticket->description,
            'due_date' => $ticket->due_date,
            'completed_by' => $ticket->completed_by,
            'created_at' => $ticket->created_at,
            'reported_by' => $ticket->reported_by_name,
            'bu_name' => $ticket->bu_name,
            'status_title' => $ticket->status_title,
            'resolved_name' => $ticket->resolved_name,
            'ticket_id' => $ticket->id

        ];

        $mailContent = view('mail', $data)->render();
        //abdulsamadq67@gmail.com
        Mail::send([], [], function ($message) use ($mailContent, $user_email) {
            $message->to($user_email, 'Service Manager')
                ->subject('Here are your login credentials for your Account')
                ->setBody($mailContent, 'text/html');
        });
        return response()->json(['message' => 'Ticket email sent']);
    }

    public function weekly_graph_inprogress($c_id)
    {

        $yearly_graph = DB::select("SELECT
        DAYNAME(week_dates.`Date`) AS `Day`,
        COALESCE(COUNT(tickets.id), 0) AS `TicketCount`
    FROM (
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 1) DAY AS `Date`
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 2) DAY
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 3) DAY
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 4) DAY
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 5) DAY
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 6) DAY
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 7) DAY
    ) AS week_dates
    LEFT JOIN vw_tickets AS tickets ON DATE(tickets.created_at) = week_dates.`Date`
                    AND YEAR(tickets.created_at) = YEAR(CURDATE())
                    AND tickets.status_title = 'In Progress'
    GROUP BY week_dates.`Date`
    ORDER BY week_dates.`Date`;", [$c_id]);
        return response()->json($yearly_graph);
    }
    public function save_filters(Request $request)
    {
        try {
            $data = $request->all();
            
            $request->validate([
                'filter_name' => 'required|string|max:200',
                'created_by' => 'required|integer'
            ]);
            
            DB::insert(
                'INSERT INTO `saved_filters` 
                (`filter_name`, `from_date`, `to_date`, `timeline`, `company`, `bu`, `customers`, `assign_to`, `created_by`, `created_at`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())',
                [
                    $data['filter_name'] ?? null,
                    $data['from_date'] ?? null,
                    $data['to_date'] ?? null,
                    $data['timeline'] ?? null,
                    $data['company'] ?? null,
                    $data['bu'] ?? null,
                    $data['customers'] ?? null,
                    $data['assign_to'] ?? null,
                    $data['created_by'] ?? null
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'View saved successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save view: ' . $e->getMessage()
            ], 500);
        }
    }
    public function get_filter($id)
    {
        try {
            $filters = DB::select(
                'SELECT * FROM `saved_filters` WHERE created_by = ? ORDER BY created_at DESC',
                [$id]
            );
            
            return response()->json($filters, 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch views'
            ], 500);
        }
    }
    public function view_filter($id)
    {
        try {
            $filters = DB::select(
                'SELECT * FROM `saved_filters` WHERE id = ?',
                [$id]
            );
            
            if (empty($filters)) {
                return response()->json([
                    'success' => false,
                    'message' => 'View not found'
                ], 404);
            }
            
            return response()->json($filters[0], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch view'
            ], 500);
        }
    }
    public function delete_filter($id)
    {
        try {
            DB::delete('DELETE FROM `saved_filters` WHERE id = ?', [$id]);
            
            return response()->json([
                'success' => true,
                'message' => 'View deleted successfully'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete view'
            ], 500);
        }
    }

    
    
    



    public function weekly_graph_open($c_id)
    {

        $yearly_graph = DB::select("SELECT
        DAYNAME(week_dates.`Date`) AS `Day`,
        COALESCE(COUNT(tickets.id), 0) AS `TicketCount`
    FROM (
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 1) DAY AS `Date`
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 2) DAY
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 3) DAY
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 4) DAY
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 5) DAY
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 6) DAY
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 7) DAY
    ) AS week_dates
    LEFT JOIN vw_tickets AS tickets ON DATE(tickets.created_at) = week_dates.`Date`
                    AND YEAR(tickets.created_at) = YEAR(CURDATE())
                    AND tickets.status_title = 'Open'
    GROUP BY week_dates.`Date`
    ORDER BY week_dates.`Date`;", [$c_id]);
        return response()->json($yearly_graph);
    }

    public function weekly_graph_completed($c_id)
    {

        $yearly_graph = DB::select("SELECT
        DAYNAME(week_dates.`Date`) AS `Day`,
        COALESCE(COUNT(tickets.id), 0) AS `TicketCount`
    FROM (
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 1) DAY AS `Date`
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 2) DAY
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 3) DAY
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 4) DAY
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 5) DAY
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 6) DAY
        UNION ALL
        SELECT CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 7) DAY
    ) AS week_dates
    LEFT JOIN vw_tickets AS tickets ON DATE(tickets.created_at) = week_dates.`Date`
                    AND YEAR(tickets.created_at) = YEAR(CURDATE())
                    AND tickets.status_title = 'Completed'
    GROUP BY week_dates.`Date`
    ORDER BY week_dates.`Date`;", [$c_id]);
        return response()->json($yearly_graph);
    }

    private function tenantCompanyId($requestedCompanyId)
    {
        $user = Auth::user();

        return $user && (int) $user->company_id !== 0
            ? $user->company_id
            : $requestedCompanyId;
    }
}
