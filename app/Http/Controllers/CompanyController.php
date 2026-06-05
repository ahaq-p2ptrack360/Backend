<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = DB::select('SELECT * FROM company where active=1');
        
        foreach ($companies as $company) {
            if ($company->profile && $company->profile !== 'null' && trim($company->profile) !== '') {
                $filename = basename($company->profile);
                $encodedFilename = urlencode($filename);
                $company->profile_url = url("/api/companies/profile-image/{$encodedFilename}");
            } else {
                $company->profile_url = null;
            }
        }
        
        return response()->json($companies);
    }

    public function store(Request $request)
    {
        $data = $request->all();
    
        \Log::info('Create Company Data:', $data);
    
        // ✅ Image Upload ka code
        $profilePath = null;
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $profilePath = $file->storeAs('company_profiles', $fileName, 'public');
        }
    
        $country_id = isset($data['country_id']) && $data['country_id'] !== '' ? $data['country_id'] : null;
        $state_id = isset($data['state_id']) && $data['state_id'] !== '' ? $data['state_id'] : null;
        $city_id = isset($data['city_id']) && $data['city_id'] !== '' ? $data['city_id'] : null;
    
        DB::insert(
            'INSERT INTO company (name, email, telephon, mobile, address_1, address_2, city_id, state_id, country_id, zipcode, status, registration_number, first_name, middle_name, last_name, website, communication, datalines, telebox, domain_id, licences, latitude, longitude, support_email, support_contact, subscription_id, profile) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $data['name'] ?? '',
                $data['email'] ?? '',
                $data['telephon'] ?? '',
                $data['mobile'] ?? '',
                $data['address_1'] ?? '',
                $data['address_2'] ?? '',
                $city_id,
                $state_id,
                $country_id,
                $data['zipcode'] ?? '',
                $data['status'] ?? 1,
                $data['registration_number'] ?? '',
                $data['first_name'] ?? '',
                $data['middle_name'] ?? '',
                $data['last_name'] ?? '',
                $data['website'] ?? '',
                $data['communication'] ?? '',
                $data['datalines'] ?? '',
                $data['telebox'] ?? '',
                $data['domain_id'] ?? 0,
                $data['licences'] ?? 0,
                $data['latitude'] ?? '',
                $data['longitude'] ?? '',
                $data['support_email'] ?? '',
                $data['support_contact'] ?? '',
                $data['subscription_id'] ?? 0,
                $profilePath, // ✅ Yeh hai file path
            ]
        );
    
        // ... baaki ka code same rahega ...
    
        $insertedId = DB::getPdo()->lastInsertId();
        DB::insert('INSERT INTO `roles`( `name`, `company_id`, `guard_name`, `is_active`) VALUES (?,?,?,?)',
            ['Vendor', $insertedId, 'web', 1]);

        DB::insert('INSERT INTO `roles`( `name`, `company_id`, `guard_name`, `is_active`) VALUES (?,?,?,?)',
            ['Customer', $insertedId, 'web', 1]);

        DB::insert('INSERT INTO `roles`( `name`, `company_id`, `guard_name`, `is_active`) VALUES (?,?,?,?)',
            ['Admin', $insertedId, 'web', 1]);

        $admininsertedid = DB::getPdo()->lastInsertId();

        $designation_id = DB::getPdo()->lastInsertId();
        $password = Str::random(8);
        $hashedPassword = Hash::make($password);
        DB::insert('INSERT INTO business_units (company_id, marketing_manager, store_manager, bu_user, name, email, phone, alternate_phone, address_1, address_2, latitude, longitude, city, state, country, zipcode, status, properties,customer_r) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)',
            [$insertedId, '0', '0', '0', 'HQ ' . $data['name'], $data['email'], $data['mobile'], $data['mobile'], $data['address_1'], $data['address_2'], $data['latitude'], $data['longitude'], $data['city_id'], $data['state_id'], $data['country_id'], $data['zipcode'], $data['status'], '[]', "yes"]);
        $buId = DB::getPdo()->lastInsertId();
        DB::table('bu_group')->insertGetId([
            'title' => 'Manager',
            'bu_id' => $buId,
            'company_id' => $insertedId,
            'created_by' => 1,
        ]);
        $bu_group = DB::getPdo()->lastInsertId();
        DB::table('bu_group')->insertGetId([
            'title' => 'Staff',
            'bu_id' => $buId,
            'company_id' => $insertedId,
            'created_by' => 1,
        ]);
        $fname = $data['first_name'];
        $lname = $data['last_name'];
        $email_var = $data['email'];
        $atSignPosition = strpos($email_var, "@");
        if ($atSignPosition !== false) {
            // Extract the domain part using substr
            $domain = substr($email_var, $atSignPosition + 1);
            $domain_ = "@" . $domain;

        } else {
            echo "Invalid email address";
        }
        $User_name = $fname . "_" . $lname . "_" . mt_rand(100, 9999);
        $user_name = $fname . "_" . $lname . "_" . mt_rand(100, 9999);
        DB::insert('INSERT INTO users (first_name, last_name, company_id, name, email,about,two_factor_secret, designation_id,  password,bu_id,role,type) VALUES ( ?, ?, ?,?, ?, ?, ?,?, ?,?,?,?)', [
            $data['first_name'],
            $data['last_name'],
            $insertedId,
            $user_name,
            $User_name,
            $data['email'],
            $password,
            $designation_id,
            $hashedPassword,
            $buId,
            $admininsertedid,
            'Admin',
        ]);
        DB::insert("INSERT INTO `role_permissions` ( `role_id`, `types`, `status`, `priority`, `impact`, `business_unit`, `assign_group`, `create_group`, `vendor`, `subscription`, `ticket`, `report`, `domain`, `company`, `user`, `account`, `designation`, `qutation`) VALUES (?, '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}', '{\"create\":1,\"read\":1,\"update\":1,\"delete\":1}')", [$admininsertedid]);

        $user_id = DB::getPdo()->lastInsertId();
        DB::update('UPDATE `business_units` SET `reponsible_user` =? WHERE id=?', [$user_id, $buId]);

        // DB::table('bu_group')->insertGetId([
        //     'title' => $data['name']." Group",
        //     'bu_id' => $buId,
        //     'company_id' => $insertedId,
        //     'created_by' => 1,
        // ]);
        // $groupId = DB::getPdo()->lastInsertId();
        // DB::insert('INSERT INTO bu_group_members (group_id, member_id) VALUES (?, ?)', [$groupId, $user_id]);
        DB::insert('INSERT INTO designations (company_id, title, active) VALUES (?, ?, ?)',
            [$insertedId, ' Company CEO', 1]);

        DB::insert('INSERT INTO designations (company_id, title, active) VALUES (?, ?, ?)',
            [$insertedId, 'Company Agent', 1]);
        DB::insert('INSERT INTO impacts (company_id, title, active) VALUES (?, ?, ?)', [$insertedId, 'High', $data['status']]);
        DB::insert('INSERT INTO impacts (company_id, title, active) VALUES (?, ?, ?)', [$insertedId, 'Medium', $data['status']]);
        DB::insert('INSERT INTO impacts (company_id, title, active) VALUES (?, ?, ?)', [$insertedId, 'Low', $data['status']]);
        DB::insert('INSERT INTO status (company_id, title, active) VALUES (?, ?, ?)', [
            $insertedId,
            'Open',
            $data['status'],
        ]);
        DB::insert('INSERT INTO status (company_id, title, active) VALUES (?, ?, ?)', [
            $insertedId,
            'Closed',
            $data['status'],
        ]);
        DB::insert('INSERT INTO status (company_id, title, active) VALUES (?, ?, ?)', [
            $insertedId,
            'Pending',
            $data['status'],
        ]);
        DB::insert('INSERT INTO types (company_id, title, parent_id, active) VALUES (?, ?, ?, ?)', [
            $insertedId,
            'Basic Type',
            '0',
            $data['status'],
        ]);
        DB::insert('INSERT INTO priority (company_id, title, active, sla) VALUES (?, ?, ?, ?)', [$insertedId, 'High', $data['status'], '1']);
        DB::insert('INSERT INTO priority (company_id, title, active, sla) VALUES (?, ?, ?, ?)', [$insertedId, 'Medium', $data['status'], '1']);
        DB::insert('INSERT INTO priority (company_id, title, active, sla) VALUES (?, ?, ?, ?)', [$insertedId, 'Low', $data['status'], '1']);

        DB::insert('INSERT INTO group_designation (bu_id, group_id, designation_id) VALUES (?, ?, ?)', [$buId, $bu_group, $designation_id]);

        // $mailContent = 'check';

        $email = $data['email'];
        $data = ['email' => $User_name,
            'password' => $password,
        ];
        $mailContent = view('mail3', $data)->render();

        Mail::send([], [], function ($message) use ($mailContent, $email) {
            $message->to($email, 'User Login Credentials')
                ->subject('User Login Credentials')
                ->setBody($mailContent, 'text/html');

        });

        return response()->json(['message' => 'Company created successfully', 'id' => $insertedId]);
    }

    public function show($id)
    {
        try {
            $companies = DB::select('SELECT * FROM company WHERE id = ?', [$id]);
    
            if (empty($companies)) {
                return response()->json(['error' => 'Company not found'], 404);
            }
    
            $company = $companies[0];
            
            // ✅ NEW: Image ka API URL banao
            if ($company->profile && $company->profile !== 'null' && trim($company->profile) !== '') {
                // Extract filename from path
                $filename = basename($company->profile); 
                
                // URL encode the filename (spaces ko %20 karein)
                $encodedFilename = urlencode($filename);
                
                // Generate new API URL
                $company->profile_url = url("/api/companies/profile-image/{$encodedFilename}");
                
            } else {
                $company->profile_url = null;
            }
    
            return response()->json($company);
    
        } catch (\Exception $e) {
            \Log::error('Company show error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch company'], 500);
        }
    }

    // public function update(Request $request, $id)
    // {
    //     $data = $request->all();

    //     DB::update('UPDATE company SET name = ?, email = ?, telephon = ?, mobile = ?, address_1 = ?, address_2 = ?, city_id = ?, state_id = ?, country_id = ?, zipcode = 321, status = 1, registration_number = ?, first_name = ?, middle_name = ?, last_name = ?, website = ?, communication = "COM", datalines = "datalines", telebox = "telebox", domain_id = ?, licences = ?, latitude = ?, longitude = ?, support_email = ?, support_contact = ?, subscription_id = ? WHERE id = ?', [$data['name'], $data['email'], $data['telephon'], $data['mobile'], $data['address_1'], $data['address_2'], $data['city_id'], $data['state_id'], $data['country_id'],  $data['registration_number'], $data['first_name'], $data['middle_name'], $data['last_name'], $data['website'], $data['domain_id'], $data['licences'], $data['latitude'], $data['longitude'], $data['support_email'], $data['support_contact'], $data['subscription_id'], $id]);

    //     return response()->json(['message' => 'Company updated successfully']);
    // }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        
        \Log::info('Update Request Data:', array_merge($data, [
            'hasFile_profile' => $request->hasFile('profile'),
            'profile_exists' => isset($data['profile']),
            'profile_type' => isset($data['profile']) ? gettype($data['profile']) : 'not_set'
        ]));
    
        // ✅ Pehle existing company ka data fetch karo
        $existingCompany = DB::select('SELECT * FROM company WHERE id = ?', [$id]);
        
        if (empty($existingCompany)) {
            return response()->json(['error' => 'Company not found'], 404);
        }
        
        $existingProfilePath = $existingCompany[0]->profile;
    
        // ✅ Image Upload ka code - IMPROVED
        $profilePath = $existingProfilePath;
        
        // CASE 1: Agar frontend ne base64 image bheji hai
        if (isset($data['profile']) && is_string($data['profile']) && 
            strpos($data['profile'], 'data:image') === 0) {
            
            \Log::info('Base64 image received from frontend');
            
            // Purani file delete karo agar exist karti hai
            if ($existingProfilePath && file_exists(storage_path('app/public/' . $existingProfilePath))) {
                unlink(storage_path('app/public/' . $existingProfilePath));
            }
            
            // Base64 decode karke file save karo
            $imageData = $data['profile'];
            list($type, $imageData) = explode(';', $imageData);
            list(, $imageData) = explode(',', $imageData);
            $imageData = base64_decode($imageData);
            
            // File extension determine karo
            $extension = 'png';
            if (strpos($type, 'jpeg') !== false) $extension = 'jpg';
            if (strpos($type, 'jpg') !== false) $extension = 'jpg';
            if (strpos($type, 'png') !== false) $extension = 'png';
            if (strpos($type, 'gif') !== false) $extension = 'gif';
            
            // File name generate karo
            $fileName = time() . '_company_profile.' . $extension;
            $profilePath = 'company_profiles/' . $fileName;
            
            // File save karo
            file_put_contents(storage_path('app/public/' . $profilePath), $imageData);
            
            \Log::info('Base64 image saved:', ['path' => $profilePath]);
        }
        elseif ($request->hasFile('profile')) {
            \Log::info('File upload received from frontend');
            
            if ($existingProfilePath && file_exists(storage_path('app/public/' . $existingProfilePath))) {
                unlink(storage_path('app/public/' . $existingProfilePath));
            }
            
            $file = $request->file('profile');
            $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $profilePath = $file->storeAs('company_profiles', $fileName, 'public');
            
            \Log::info('File uploaded:', ['path' => $profilePath]);
        }
        elseif (isset($data['existing_profile_image']) && $data['existing_profile_image']) {
            $profilePath = $data['existing_profile_image'];
            \Log::info('Using existing profile image:', ['path' => $profilePath]);
        }
    
        // ✅ Required fields validation
        if (empty($data['name']) || empty($data['email']) || empty($data['mobile'])) {
            \Log::error('Missing required fields in update request');
            return response()->json(['error' => 'Required fields are missing'], 400);
        }
    
        $country_id = isset($data['country_id']) && $data['country_id'] !== '' ? $data['country_id'] : null;
        $state_id = isset($data['state_id']) && $data['state_id'] !== '' ? $data['state_id'] : null;
        $city_id = isset($data['city_id']) && $data['city_id'] !== '' ? $data['city_id'] : null;
    
        $domain_id = isset($data['domain_id']) ? (int) $data['domain_id'] : 0;
        $licences = isset($data['licences']) ? (int) $data['licences'] : 0;
        $subscription_id = isset($data['subscription_id']) ? (int) $data['subscription_id'] : 0;
    
        try {
            DB::update('UPDATE company SET 
                name = ?, 
                email = ?, 
                telephon = ?, 
                mobile = ?, 
                address_1 = ?, 
                address_2 = ?, 
                city_id = ?, 
                state_id = ?, 
                country_id = ?, 
                zipcode = ?, 
                status = ?, 
                registration_number = ?, 
                first_name = ?, 
                middle_name = ?, 
                last_name = ?, 
                website = ?, 
                communication = ?, 
                datalines = ?, 
                telebox = ?, 
                domain_id = ?, 
                licences = ?, 
                latitude = ?, 
                longitude = ?, 
                support_email = ?, 
                support_contact = ?, 
                subscription_id = ?,
                profile = ? 
                WHERE id = ?', [
                
                $data['name'] ?? '',
                $data['email'] ?? '',
                $data['telephon'] ?? '',
                $data['mobile'] ?? '',
                $data['address_1'] ?? '',
                $data['address_2'] ?? '',
                $city_id,
                $state_id,
                $country_id,
                $data['zipcode'] ?? '321',
                $data['status'] ?? 1,
                $data['registration_number'] ?? '',
                $data['first_name'] ?? '',
                $data['middle_name'] ?? '',
                $data['last_name'] ?? '',
                $data['website'] ?? '',
                $data['communication'] ?? 'COM',
                $data['datalines'] ?? 'datalines',
                $data['telebox'] ?? 'telebox',
                $domain_id,
                $licences,
                $data['latitude'] ?? '',
                $data['longitude'] ?? '',
                $data['support_email'] ?? '',
                $data['support_contact'] ?? '',
                $subscription_id,
                $profilePath, // ✅ File path update ho raha hai
                $id,
            ]);
    
            \Log::info('Company updated successfully:', [
                'id' => $id, 
                'profile_path' => $profilePath,
                'profile_url' => url('storage/' . $profilePath)
            ]);
            
            return response()->json([
                'message' => 'Company updated successfully',
                'profile_path' => $profilePath,
                'profile_url' => url('storage/' . $profilePath)
            ]);
    
        } catch (\Exception $e) {
            \Log::error('Update Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update company: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM company WHERE id = ?', [$id]);
        return response()->json(['message' => 'Company deleted successfully']);
    }
    public function company_profile($id)
    {
        $company_profile = DB::select('SELECT c.*, d.title as domain, sp.title as subscription
        FROM `company` c
        JOIN `domains` d ON c.domain_id = d.id
        LEFT JOIN `subscription_package` sp ON c.subscription_id = sp.id
        WHERE c.id = ? and active=1', [$id]);
        
        if (!empty($company_profile)) {
            $company = $company_profile[0];
            if ($company->profile && $company->profile !== 'null' && trim($company->profile) !== '') {
                $filename = basename($company->profile);
                $encodedFilename = urlencode($filename);
                $company->profile_url = url("/api/companies/profile-image/{$encodedFilename}");
            } else {
                $company->profile_url = null;
            }
        }
        
        return response()->json($company_profile);
    }
    public function com_pro_update(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('profile')) {
            $profilePath = $request->file('profile')->store('documents', 'public');
        } else {
            $profilePath = null;
        }

        DB::update('UPDATE `company` SET `telephon`=?,`mobile`=?,
        `address_1`=?,`address_2`=?,`city_id`=?,`state_id`=?,
        `country_id`=?,`registration_number`=?,`website`=?,
        `domain_id`=?,`licences`=?,`latitude`=?,`longitude`=?,
        `support_email`=?,`support_contact`=?,`subscription_id`=?,
        `profile`=? WHERE id=?',
            [$data['telephon'], $data['mobile'],
                $data['address_1'], $data['address_2'],
                $data['city_id'], $data['state_id'],
                $data['country_id'], $data['registration_number'],
                $data['website_'], $data['domain_id'],
                $data['licences'], $data['latitude'],
                $data['longitude'], $data['support_email'],
                $data['support_contact'], $data['subscription_id']
                , $profilePath, $data['id']]);

    }

    public function serveProfileImage($filename)
{
    try {
        // Decode URL encoded filename
        $decodedFilename = urldecode($filename);
        
        // File ka complete path
        $path = storage_path('app/public/company_profiles/' . $decodedFilename);
        
        \Log::info('Image request:', [
            'filename' => $filename,
            'decoded' => $decodedFilename,
            'path' => $path
        ]);
        
        // Check if file exists
        if (!file_exists($path)) {
            \Log::error("Image not found at path: " . $path);
            
            // Return default image ya 404
            $defaultPath = storage_path('app/public/company_profiles/default.png');
            if (file_exists($defaultPath)) {
                return response()->file($defaultPath);
            }
            
            abort(404, 'Profile image not found');
        }
        
        // Get file extension and set proper content type
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
        ];
        
        $contentType = $mimeTypes[$extension] ?? 'image/jpeg';
        
        // Return file with proper headers
        return response()->file($path, [
            'Content-Type' => $contentType,
            'Cache-Control' => 'public, max-age=31536000',
            'Access-Control-Allow-Origin' => '*', // CORS header
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error serving profile image: ' . $e->getMessage());
        abort(500, 'Failed to load image');
    }
}

    // public function updatecompstatus(Request $request)
    // {
    //     $data = $request->all();
    //     DB::update('UPDATE company SET active = ? WHERE id = ?', [
    //         $data['active'],
    //         $data['id'],

    //     ]);
    //     return response()->json(['message' => 'Type status updated successfully']);
    // }

    public function updatecompstatus(Request $request)
{
    $request->validate([
        'id' => 'required|integer',
        'active' => 'required|in:0,1'
    ]);

    DB::table('company')
        ->where('id', $request->id)
        ->update([
            'active' => $request->active
        ]);

    return response()->json([
        'success' => true,
        'message' => 'Company status updated successfully'
    ]);
}


}
