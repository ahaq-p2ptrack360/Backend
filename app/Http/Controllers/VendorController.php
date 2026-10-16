<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
class VendorController extends Controller
{
    public function index()
    {
        $sql = 'SELECT s.*,IFNULL(c.name,"System") as company FROM `vendors` s left join company c on s.company_id = c.id where s.active =1';
        $bindings = [];
        if ($this->tenantCompanyId() !== null) {
            $sql .= ' AND s.company_id = ?';
            $bindings[] = $this->tenantCompanyId();
        }
        $vendors = DB::select($sql, $bindings);
        return response()->json($vendors);
    }

//     public function store(Request $request)
//     {
//         $data = $request->all();
    
//         DB::beginTransaction();
    
//         try {
//             // Hash the password
//             $hashedPassword = Hash::make($data['password']);
//             $roleid= DB::select("select * from roles where company_id=? and name='Vendor'",[$data['company_id']]);
//             DB::insert("
//     INSERT INTO `role_permissions` 
//     (`role_id`, `types`, `status`, `priority`, `impact`, `business_unit`, `assign_group`, `create_group`, `vendor`, `subscription`, `ticket`, `report`, `domain`, `company`, `user`, `account`, `designation`, `qutation`) 
//     VALUES (
//         ?, 
//         '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
//         '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
//         '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
//         '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
//         '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
//         '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
//         '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
//         '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
//         '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
//         '{\"create\":0,\"read\":1,\"update\":0,\"delete\":0}', 
//         '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
//         '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
//         '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
//         '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
//         '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
//         '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
//         '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}'
//     )
// ", [$roleid[0]->id]);
        
//             // Insert user
//             DB::insert(
//                 'INSERT INTO users (first_name, last_name, company_id, name, email, about, two_factor_secret, designation_id, bu_id, password, type,role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)',
//                 [
//                     $data['name'],
//                     "",
//                     $data['company_id'],
//                     $data['email'],
//                     $data['email'],
//                     "",
//                     $data['password'],
//                     "1",
//                     $data['bu_id'],
//                     $hashedPassword,
//                     "vendor",
//                     $roleid[0]->id
//                 ]
//             );
    
//             // Get last inserted user ID
//             $insertedId = DB::getPdo()->lastInsertId();
   
//             DB::insert("INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('1', 'App\\Models\\User', $insertedId)");
    
//             // Insert vendor
//             DB::insert(
//                 'INSERT INTO vendors (company_id, vendor_type_id, name, email, phone, alternate_phone, address_1, address_2, latitude, longitude, city, state, country, zipcode, status, bu_id, password, userId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
//                 [
//                     $data['company_id'],
//                     $data['vendor_type_id'],
//                     $data['name'],
//                     $data['email'],
//                     $data['phone'],
//                     $data['alternate_phone'],
//                     $data['address_1'],
//                     $data['address_2'],
//                     $data['latitude'],
//                     $data['longitude'],
//                     $data['city'],
//                     $data['state'],
//                     $data['country'],
//                     $data['zipcode'],
//                     $data['status'],
//                     $data['bu_id'],
//                     $data['password'], // Consider hashing or removing this for security
//                     $insertedId
//                 ]
//             );
    
//             DB::commit();
//             return response()->json(['message' => 'Vendor created successfully']);
    
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return response()->json(['error' => 'Failed to create vendor: ' . $e->getMessage()], 500);
//         }
//     }
    
public function store(Request $request)
{
    $data = $request->all();
        $data['company_id'] = $this->tenantCompanyId() ?? ($data['company_id'] ?? null);
    
    DB::beginTransaction();
    
    try {
        // Hash the password
        $hashedPassword = Hash::make($data['password']);
        
        // YEH PART COMPLETELY CHANGE KARO
        $roleid = DB::select("select * from roles where company_id=? and name='Vendor'",[$data['company_id']]);
        
        // Agar role nahi mila tou automatically create kar do
        if(empty($roleid)) {
            DB::insert("INSERT INTO roles (company_id, name, guard_name, is_active) VALUES (?, 'Vendor', 'web', 1)", [$data['company_id']]);
            $roleid = DB::select("select * from roles where company_id=? and name='Vendor'",[$data['company_id']]);
        }
        
        $role_id = $roleid[0]->id;
        
        // Baaki code same rakho
        DB::insert("
            INSERT INTO `role_permissions` 
            (`role_id`, `types`, `status`, `priority`, `impact`, `business_unit`, `assign_group`, `create_group`, `vendor`, `subscription`, `ticket`, `report`, `domain`, `company`, `user`, `account`, `designation`, `qutation`) 
            VALUES (
                ?, 
                '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
                '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
                '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
                '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
                '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
                '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
                '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
                '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
                '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
                '{\"create\":0,\"read\":1,\"update\":0,\"delete\":0}', 
                '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
                '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
                '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
                '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
                '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
                '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}', 
                '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}'
            )
        ", [$role_id]);
        
        // Insert user
        DB::insert(
            'INSERT INTO users (first_name, last_name, company_id, name, email, about, two_factor_secret, designation_id, bu_id, password, type,role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)',
            [
                $data['name'],
                "",
                $data['company_id'],
                $data['email'],
                $data['email'],
                "",
                $data['password'],
                "1",
                $data['bu_id'],
                $hashedPassword,
                "vendor",
                $role_id
            ]
        );

        // Get last inserted user ID
        $insertedId = DB::getPdo()->lastInsertId();
   
        DB::insert("INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (?, 'App\\Models\\User', ?)", [$role_id, $insertedId]);

        // Insert vendor
        DB::insert(
            'INSERT INTO vendors (company_id, vendor_type_id, name, email, phone, alternate_phone, address_1, address_2, latitude, longitude, city, state, country, zipcode, status, bu_id, password, userId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $data['company_id'],
                $data['vendor_type_id'],
                $data['name'],
                $data['email'],
                $data['phone'],
                $data['alternate_phone'],
                $data['address_1'],
                $data['address_2'],
                $data['latitude'],
                $data['longitude'],
                $data['city'],
                $data['state'],
                $data['country'],
                $data['zipcode'],
                $data['status'],
                $data['bu_id'],
                $data['password'],
                $insertedId
            ]
        );

        DB::commit();
        return response()->json(['message' => 'Vendor created successfully']);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Failed to create vendor: ' . $e->getMessage()], 500);
    }
}

    public function show($id)
    {
        $query = DB::table('vendors')->where('id', $id);
        if ($this->tenantCompanyId() !== null) {
            $query->where('company_id', $this->tenantCompanyId());
        }
        $vendor = $query->get();
        return response()->json($vendor);
    }

    public function showbytype($id)
    {
        $sql = 'SELECT v.*,c.name as company,b.name as business_units FROM vendors v left join company c on v.company_id = c.id left join business_units b on v.bu_id = b.id WHERE vendor_type_id = ?';
        $bindings = [$id];
        if ($this->tenantCompanyId() !== null) {
            $sql .= ' AND v.company_id = ?';
            $bindings[] = $this->tenantCompanyId();
        }
        $vendor = DB::select($sql, $bindings);
        return response()->json($vendor);
    }

    // public function update(Request $request, $id)
    // {
    //     $data = $request->all();
    //     DB::update(
    //         'UPDATE vendors SET company_id = ?, vendor_type_id = ?, name = ?, email = ?, phone = ?, alternate_phone = ?, address_1 = ?, address_2 = ?, latitude = ?, longitude = ?, city = ?, state = ?, country = ?, zipcode = ?, status = ?, bu_id = ? WHERE id = ?',
    //         [$data['company_id'], $data['vendor_type_id'], $data['name'], $data['email'], $data['phone'], $data['alternate_phone'], $data['address_1'], $data['address_2'], $data['latitude'], $data['longitude'], $data['city'], $data['state'], $data['country'], $data['zipcode'], $data['status'], $data['bu_id'], $id]
    //     );

    //     return response()->json(['message' => 'Vendor updated successfully']);
    // }

    public function update(Request $request, $id)
{
    $data = $request->all();
        $data['company_id'] = $this->tenantCompanyId() ?? ($data['company_id'] ?? null);
    
    // YEH VALIDATION ADD KARO - LINE 88 KE BAAD
    if (!isset($data['company_id'])) {
        return response()->json([
            'success' => false,
            'message' => 'Company ID is required'
        ], 422);
    }
    
    // Baaki update code same rakho
    DB::update(
        'UPDATE vendors SET company_id = ?, vendor_type_id = ?, name = ?, email = ?, phone = ?, alternate_phone = ?, address_1 = ?, address_2 = ?, latitude = ?, longitude = ?, city = ?, state = ?, country = ?, zipcode = ?, status = ?, bu_id = ? WHERE id = ? AND company_id = ?',
        [$data['company_id'], $data['vendor_type_id'], $data['name'], $data['email'], $data['phone'], $data['alternate_phone'], $data['address_1'], $data['address_2'], $data['latitude'], $data['longitude'], $data['city'], $data['state'], $data['country'], $data['zipcode'], $data['status'], $data['bu_id'], $id, $data['company_id']]
    );

    return response()->json(['message' => 'Vendor updated successfully']);
}

    public function companywise($id)
    {
        $id = $this->tenantCompanyId() ?? $id;
        $vendor = DB::select('SELECT s.*,IFNULL(c.name,"System") as company FROM `vendors` s left join company c on s.company_id = c.id WHERE company_id = ? and  s.active =1', [$id]);
        return response()->json($vendor);
    }

    public function destroy($id)
    {
        $query = DB::table('vendors')->where('id', $id);
        if ($this->tenantCompanyId() !== null) {
            $query->where('company_id', $this->tenantCompanyId());
        }
        $query->delete();
        return response()->json(['message' => 'Vendor deleted successfully']);
    }
    public function updatevendorstatus(Request $request)
    {
        $data = $request->all();
        $query = DB::table('vendors')->where('id', $data['id']);
        if ($this->tenantCompanyId() !== null) {
            $query->where('company_id', $this->tenantCompanyId());
        }
        $query->update(['active' => $data['active']]);
        return response()->json(['message' => 'Type status updated successfully']);
    }
    public function storevendor_tickets(Request $request)
    {
        $data = $request->all();
        if (!$this->ticketBelongsToTenant($data['ticket_id'] ?? null)
            || !$this->vendorBelongsToTenant($data['vendor_id'] ?? null)) {
            return response()->json(['error' => 'Ticket or vendor not found'], 404);
        }
        // You need to adjust the field names according to your table structure
        DB::insert('INSERT INTO `vendor_tickets`(`ticket_id`, `vendor_id`, `status`) VALUES (?,?,?)', [
            $data['ticket_id'],
            $data['vendor_id'],
            $data['status']
            
        ]);
      

        return response()->json(['message' => 'Vendor created successfully']);
    }

    public function showvt($id)
    {
        $sql = 'SELECT t.*,q.amount,vt.id as vid ,vt.vendor_id as vendorId FROM vendor_tickets vt join vw_tickets t on t.id = vt.ticket_id left join qoutations q on vt.ticket_id =q.ticket_id WHERE vt.id = ? and vt.status =1';
        $bindings = [$id];
        if ($this->tenantCompanyId() !== null) {
            $sql .= ' AND t.company_id = ?';
            $bindings[] = $this->tenantCompanyId();
        }
        $vendor = DB::select($sql, $bindings);
        return response()->json($vendor);
    }
    public function vendorbytype($id)
    {
        $sql = 'SELECT * from vendors where vendor_type_id=?';
        $bindings = [$id];
        if ($this->tenantCompanyId() !== null) {
            $sql .= ' AND company_id = ?';
            $bindings[] = $this->tenantCompanyId();
        }
        $vendor = DB::select($sql, $bindings);
        return response()->json($vendor);
    }
    public function qutationsbyticket($id)
    {
        if (!$this->ticketBelongsToTenant($id)) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }
        $sql = 'SELECT q.*,v.name as vendor from qoutations q join vendors v on q.vendor_id = v.id where ticket_id=?';
        $bindings = [$id];
        if ($this->tenantCompanyId() !== null) {
            $sql .= ' AND q.company_id = ?';
            $bindings[] = $this->tenantCompanyId();
        }
        $vendor = DB::select($sql, $bindings);
        return response()->json($vendor);
    }
    public function sendemailtovendor($vid, $tid)
{
    // Get vendor and ticket data
        $vendor = DB::table('vendors')->where('id', $vid)->when($this->tenantCompanyId() !== null, function ($query) {
            $query->where('company_id', $this->tenantCompanyId());
        })->get();
        $ticket = DB::table('tickets')->where('id', $tid)->when($this->tenantCompanyId() !== null, function ($query) {
            $query->where('company_id', $this->tenantCompanyId());
        })->get();

    // Check if both exist
    if ($vendor->isEmpty() || $ticket->isEmpty()) {
        return response()->json(['error' => 'Vendor or Ticket not found'], 404);
    }

    $vendor = $vendor[0];
    $ticket = $ticket[0];

    $email = $vendor->email ?? null;

    if (!$email) {
        return response()->json(['error' => 'Vendor email not found'], 400);
    }

    // Email content (HTML)
    $mailContent = "
        <h2>Request for Quotation</h2>
        <p>Dear <strong>{$vendor->name}</strong>,</p>

        <p>We would like to invite you to submit a quotation for the following ticket:</p>

        <table cellpadding='8' cellspacing='0' border='1' style='border-collapse: collapse;'>
            <tr>
                <th>Ticket ID</th>
                <td>{$ticket->id}</td>
            </tr>
            <tr>
                <th>Title</th>
                <td>{$ticket->title}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{$ticket->description}</td>
            </tr>
            <tr>
                <th>Due Date</th>
                <td>{$ticket->due_date}</td>
            </tr>
        </table>

        <p>Please review the details and submit your quotation at your earliest convenience.</p>

        <p>If you have any questions, feel free to reach out.</p>

        <p>Best regards,<br><strong>Service Manager Team</strong></p>
    ";

    // Send email
    Mail::send([], [], function ($message) use ($mailContent, $email) {
        $message->to($email)
            ->subject('Request for Quotation on Ticket')
            ->setBody($mailContent, 'text/html');
    });

    return response()->json(['success' => 'Email sent to vendor successfully']);
}

    private function tenantCompanyId()
    {
        $request = app('request');
        return $request->attributes->get('tenant_platform_admin')
            ? null
            : $request->attributes->get('tenant_company_id');
    }

    private function ticketBelongsToTenant($ticketId)
    {
        $query = DB::table('tickets')->where('id', $ticketId);
        if ($this->tenantCompanyId() !== null) {
            $query->where('company_id', $this->tenantCompanyId());
        }
        return $query->exists();
    }

    private function vendorBelongsToTenant($vendorId)
    {
        $query = DB::table('vendors')->where('id', $vendorId);
        if ($this->tenantCompanyId() !== null) {
            $query->where('company_id', $this->tenantCompanyId());
        }
        return $query->exists();
    }
}
