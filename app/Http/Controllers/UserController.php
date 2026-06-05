<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

class UserController extends Controller
{
    public function super_admin_users()
    {
        $users = DB::select('SELECT u.*, CONCAT(u.first_name, " ", u.last_name) as u_name, IFNULL(c.name, "System") AS company, d.title FROM users u LEFT JOIN company c ON u.company_id = c.id LEFT JOIN designations d ON u.designation_id = d.id where u.active =1');
        return response()->json($users);

    }
    public function forgot_password_get($email)
    {
        $users = DB::select('SELECT * FROM `users` WHERE email = ?', [$email]);
        return response()->json($users);
    }
    public function reset_password(Request $request)
    {
        $data = $request->all();
        $hashedPassword = Hash::make($data['password']);
        DB::update('update users set two_factor_secret=? , password=? WHERE email=?', [$hashedPassword, $data['password'], $data['email']]);
    }
    public function index2()
    {
        $users = DB::select('SELECT s.*,IFNULL(c.name,"System") as company FROM `users` s left join company c on s.company_id = c.id where s.active=1');
        return response()->json($users);
    }

    public function profile_update(Request $request)
    {
        $data = $request->all();
        $hashedPassword = Hash::make($data['password']);

        if ($request->hasFile('profile')) {
            $profilePath = $request->file('profile')->store('documents', 'public');
        } else {
            $profilePath = null;
        }
        DB::update('UPDATE `users` SET `first_name`=?,`last_name`=?,`photo_url`= ?,password=?,two_factor_secret=?, WHERE id=?', [$data['firstname'], $data['lastname'], $profilePath, $hashedPassword, $data['password'], $data['id']]);

        return response()->json(['message' => 'Profile Updated Successfully']);

    }

    public function store(Request $request)
    {
        $data = $request->all();
        $hashedPassword = Hash::make($data['password']);
        $fname = $data['first_name'];
        $lname = $data['last_name'];
        $email_var = $data['about'];
        $atSignPosition = strpos($email_var, "@");
        if ($atSignPosition !== false) {
            // Extract the domain part using substr
            $domain = substr($email_var, $atSignPosition + 1);
            $domain_ = "@" . $domain;

        } else {
            echo "Invalid email address";
        }
        $User_name = $data['username'];

        // You need to adjust the field names according to your table structure
        DB::insert('INSERT INTO users (first_name, last_name, company_id, name,email, about,two_factor_secret, designation_id,bu_id,  password,type,role) VALUES ( ?,?,?, ?,?, ?, ?, ?, ?,?,?,?)', [
            $data['first_name'],
            $data['last_name'],
            $data['company_id'],
            $data['username'],
            $User_name,
            $data['about'],
            $data['password'],
            $data['designation_id'],
            $data['bu_id'],
            $hashedPassword,
            'user',
            $data['role'],
        ]);
        $email = $data['about'];
        $password = $data['password'];
        $data = ['email' => $User_name,
            'password' => $password];
        $mailContent = view('mail3', $data)->render();
        $insertedUserId = DB::getPdo()->lastInsertId();
        DB::insert("INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('1', 'App\\Models\\User', $insertedUserId)");

        Mail::send([], [], function ($message) use ($mailContent, $email) {
            $message->to($email, 'User Login Credentials')
                ->subject('User Login Credentials')
                ->setBody($mailContent, 'text/html');

        });
        return response()->json(['message' => 'User created successfully']);
    }

    public function verify_username_up($id, $name)
    {
        $user = DB::select('SELECT * FROM `users` WHERE not id=? and name=?', [$id, $name]);
        return response()->json($user);
    }
    public function verify_username($name)
    {
        $user = DB::select('SELECT * FROM users WHERE name = ?', [$name]);
        return response()->json($user);
    }
    public function show($id)
    {
        $user = DB::select('SELECT * FROM users WHERE id = ?', [$id]);
        return response()->json($user);
    }
    public function groupdesignationuser($bu_id, $des_id)
    {

        $groupdesignationuser = DB::select('SELECT * FROM `group_designation` gd WHERE `bu_id`=? and designation_id = ? limit 1', [$bu_id, $des_id]);
        return response()->json($groupdesignationuser);
    }
    public function bugroupname($id)
    {

        $bugroupname = DB::select('SELECT title FROM `bu_group` WHERE id=?', [$id]);
        return response()->json($bugroupname);
    }

    public function update(Request $request, $id)
    {
        $user = DB::table('users')->where('id', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $firstName = $request->input('first_name', $user->first_name);
        $lastName = $request->input('last_name', $user->last_name);
        $email = $request->input('email', $user->email);
        $bu_id = $request->input('bu_id', $user->bu_id);
        $designation_id = $request->input('designation_id', $user->designation_id);

        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        } else {
            $password = $user->password;
        }

        DB::update(
            'UPDATE users
         SET first_name=?, last_name=?, email=?, designation_id=?, bu_id=?, password=?
         WHERE id=?',
            [
                $firstName,
                $lastName,
                $email,
                $designation_id,
                $bu_id,
                $password,
                $id,
            ]
        );

        return response()->json(['message' => 'User updated successfully']);
    }

    public function companywise($id)
    {
        $status = DB::select('SELECT u.*,CONCAT(u.first_name," ",u.last_name) as u_name ,IFNULL(c.name, "System") AS company, d.title
        FROM users u
        LEFT JOIN company c ON u.company_id = c.id
        LEFT JOIN designations d ON u.designation_id = d.id
        WHERE u.company_id = ? and u.active =1', [$id]);
        return response()->json($status);
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM users WHERE id = ?', [$id]);
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function getProfilePicture($filename)
    {
        // $path = public_path('public/documents/' . $filename);
        $path = dirname(__DIR__, 3);
        $path = $path . "/storage/app/public/documents/" . $filename;
        // dd($path);
        return response()->file($path);
    }

    public function store_customer(Request $request)
    {
        $data = $request->all();

        // Handle profile image upload
        if ($request->hasFile('profile')) {
            $profilePath = $request->file('profile')->store('documents', 'public');
        } else {
            $profilePath = null;
        }

        DB::beginTransaction();

        try {
            // Hash the password from request
            $hashedPassword = Hash::make($data['password']);

            // $roleid = DB::select("select * from roles where company_id=? and name='Customer'",['{{Auth::user()->company_id}}']);

            $roleid = DB::select("select * from roles where name='Customer' limit 1");

            // Check if role exists
            if (empty($roleid)) {
                return response()->json(['error' => 'Customer role not found in system'], 500);
            }

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
            '{\"create\":1,\"read\":1,\"update\":1,\"delete\":0}',
            '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}',
            '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}',
            '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}',
            '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}',
            '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}',
            '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}',
            '{\"create\":0,\"read\":0,\"update\":0,\"delete\":0}'
        )
    ", [$roleid[0]->id]);

            // Insert user
            DB::insert(
                'INSERT INTO users (first_name, last_name, company_id, name, email, about, two_factor_secret, designation_id, bu_id, password, type,role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)',
                [
                    $data['first_name'],
                    $data['last_name'],
                    $data['company_id'],
                    $data['first_name'] . ' ' . $data['last_name'],
                    $data['email'],
                    "",
                    null,
                    "1",
                    $data['bu_id'],
                    $hashedPassword,
                    "customer",
                    $roleid[0]->id,
                ]
            );

            $insertedUserId = DB::getPdo()->lastInsertId();

            DB::insert("INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (?, 'App\\Models\\User', ?)", [$roleid[0]->id, $insertedUserId]);

            // Insert customer
            DB::insert(
                'INSERT INTO `customers` (`first_name`, `last_name`, `email`, `phone_no`, `profile_img`, `address`, `city`, `state`, `country`, `company_id`, `bu_id`, `userId`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                [
                    $data['first_name'],
                    $data['last_name'],
                    $data['email'],
                    $data['phone_no'],
                    $profilePath,
                    $data['address'],
                    $data['city'],
                    $data['state'],
                    $data['country'],
                    $data['company_id'],
                    $data['bu_id'],
                    $insertedUserId,
                ]
            );

            DB::commit();
            return response()->json(['message' => 'Customer created successfully.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create customer: ' . $e->getMessage()], 500);
        }
    }

    public function customer_update(Request $request, $id)
    {
        $data = $request->all();

        if ($request->hasFile('profile')) {
            $profilePath = $request->file('profile')->store('documents', 'public');
            DB::update('UPDATE `customers` SET `first_name`=?,`last_name`=?,`email`=?,`phone_no`=?,`profile_img`=?,`address`=?,`city`=?,`state`=?,`country`=?,company_id=?,bu_id=?  WHERE id = ?', [
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['phone_no'],
                $profilePath,
                $data['address'],
                $data['city'],
                $data['state'],
                $data['country'],
                $data['company_id'],
                $data['bu_id'],
                $id,
            ]);
        } else {
            // $profilePath = null;
            DB::update('UPDATE `customers` SET `first_name`=?,`last_name`=?,`email`=?,`phone_no`=?,`address`=?,`city`=?,`state`=?,`country`=?,company_id=?,bu_id=?  WHERE id = ?', [
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['phone_no'],
                $data['address'],
                $data['city'],
                $data['state'],
                $data['country'],
                $data['company_id'],
                $data['bu_id'],
                $id,
            ]);
        }

        return response()->json(['message' => 'Customer updated successfully']);
    }

    public function getCustomerById($id)
{
    $customer = DB::select('SELECT * FROM customers WHERE id = ?', [$id]);
    
    if (empty($customer)) {
        return response()->json(['error' => 'Customer not found'], 404);
    }
    
    // Users table se bhi related data le sakte hain
    $user = DB::select('SELECT * FROM users WHERE id = (SELECT userId FROM customers WHERE id = ?)', [$id]);
    
    $response = $customer[0];
    if (!empty($user)) {
        $response->email = $user[0]->email;
    }
    
    return response()->json($response);
}

    public function customer_show($id)
    {
        $user = DB::select('SELECT * FROM customers WHERE company_id = ? and active=1', [$id]);
        return response()->json($user);
    }
    public function super_admin_customer()
    {
        $user = DB::select('SELECT * FROM customers where active =1');
        return response()->json($user);
    }

    public function show_customer_by_id($id)
    {
        $user = DB::select('SELECT * FROM customers WHERE company_id = ? and active =1', [$id]);
        return response()->json($user);
    }
    public function show_customer($id)
    {
        $user = DB::select('SELECT * FROM customers WHERE id = ?', [$id]);
        return response()->json($user);
    }

    public function show_customer_by_bu_id($id)
    {
        $user = DB::select('SELECT * FROM customers WHERE bu_id = ? and active =1', [$id]);
        return response()->json($user);
    }
    public function show_user_des($id)
    {
        $user = DB::select('SELECT u.*,d.title as designations FROM `users` u
        JOIN designations d
        ON u.designation_id = d.id
        WHERE u.id=?', [$id]);
        return response()->json($user);
    }

    public function updateuserstatus(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'active' => 'required|in:0,1',
        ]);

        DB::table('users')
            ->where('id', $request->id)
            ->update([
                'active' => $request->active,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully',
        ]);
    }

    public function updatecusstatus(Request $request)
    {
        $data = $request->all();
        DB::update('UPDATE customers SET active = ? WHERE id = ?', [
            $data['active'],
            $data['id'],

        ]);
        return response()->json(['message' => 'Type status updated successfully']);
    }
    
    public function companyprofile($id)
    {
       
      $company=  DB::select('SELECT 
      c.*,
      COUNT(u.name) AS users,
      d.title AS domain_title,
      sp.title AS subscription_title,
      (SELECT COUNT(id) FROM business_units bu WHERE bu.company_id = ?) AS total_bu,
      (SELECT COUNT(id) FROM tickets t WHERE t.company_id = u.company_id) AS total_tickets
  FROM users u
  JOIN company c ON u.company_id = c.id
  LEFT JOIN domains d ON c.domain_id = d.id
  LEFT JOIN subscription_package sp ON c.subscription_id = sp.id
  WHERE c.id = ?
  GROUP BY
      c.id,
      c.name,
      c.email,
      c.telephon,
      c.mobile,
      c.address_1,
      c.address_2,
      c.city_id,
      c.state_id,
      c.country_id,
      c.zipcode,
      c.status,
      c.created_by,
      c.updated_by,
      c.created_at,
      c.updated_at,
      c.deleted_at,
      c.registration_number,
      c.region,
      c.first_name,
      c.middle_name,
      c.last_name,
      c.website,
      c.communication,
      c.datalines,
      c.telebox,
      c.comments,
      c.language,
      c.domain_id,
      c.licences,
      c.latitude,
      c.longitude,
      c.active,
      c.support_email,
      c.support_contact,
      c.subscription_id,
      c.profile,
      d.title,
      sp.title,
      u.company_id;
  ',[$id,$id]);
        return response()->json(['response' => $company]);
    }
}

