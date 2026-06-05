<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusinessUnitController extends Controller
{
    public function index()
    {
        $businessUnits = DB::select('SELECT s.*,IFNULL(c.name,"System") as company FROM `business_units` s left join company c on s.company_id = c.id;');
        return response()->json($businessUnits);
    }

    public function vendorbu($id)
    {
        $businessUnits = DB::select('SELECT s.*,IFNULL(c.name,"System") as company FROM `business_units` s left join company c on s.company_id = c.id where vendor_r = "yes" and company_id = ?', [$id]);
        return response()->json($businessUnits);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        DB::insert('INSERT INTO business_units (company_id, marketing_manager, store_manager, bu_user, name, email, phone, alternate_phone, address_1, address_2, latitude, longitude, city, state, country, zipcode, status, properties,vendor_r,customer_r,parent_bu_id,reponsible_user,ticket_represented) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?)',
            [$data['company_id'], $data['marketing_manager'], $data['store_manager'], $data['bu_user'], $data['name'], $data['email'], $data['phone'], $data['alternate_phone'], $data['address_1'], $data['address_2'], $data['latitude'], $data['longitude'], $data['city'], $data['state'], $data['country'], $data['zipcode'], $data['status'], $data['properties'],$data['vendor_r'],$data['customer_r'],$data['parent_bu_id'],$data['responsible'],$data['ticket_represented'] ?? '']);
        $insertedId = DB::getPdo()->lastInsertId();
        DB::table('bu_group')->insertGetId([
            'title' => 'Manager',
            'bu_id' => $insertedId,
            'company_id' => $data['company_id'],
            'created_by' => 1,
        ]);
        DB::table('bu_group')->insertGetId([
            'title' => 'Staff',
            'bu_id' => $insertedId,
            'company_id' => $data['company_id'],
            'created_by' => 1,
        ]);

        if ($insertedId) {

            return response()->json(['message' => 'Business unit created successfully', 'inserted_id' => $insertedId]);
        } else {
            return response()->json(['message' => 'Failed to create business unit'], 500);
        }
    }

    public function show($id)
    {
        $businessUnit = DB::select('SELECT * FROM business_units WHERE id = ?', [$id]);
        return response()->json($businessUnit);
    }
    public function companywise($id)
    {
        $businessUnits = DB::select('SELECT s.*,IFNULL(c.name,"System") as company FROM `business_units` s left join company c on s.company_id = c.id where company_id = ?', [$id]);
        return response()->json($businessUnits);
    }

    public function companywise_by_company_r($id)
    {
        $businessUnits = DB::select('SELECT s.*,IFNULL(c.name,"System") as company FROM `business_units` s left join company c on s.company_id = c.id where company_id = ? AND customer_r= "yes" ', [$id]);
        return response()->json($businessUnits);
    }
    public function parent_bu_wise($c_id,$buID,$group)
    {
       $parent_bu= DB::select('SELECT parent_bu_id FROM `business_units` WHERE `company_id`=? AND business_units.id=?', [$c_id,$buID]) ;
       $parent_bu_id = $parent_bu[0]->parent_bu_id;
       if($parent_bu_id==NULL){
        $businessUnits =DB::select('SELECT * FROM `business_units` WHERE `company_id`=?', [$c_id]);
       }
       else if($group == 'Staff'){
        $businessUnits =DB::select('SELECT * FROM `business_units` WHERE `company_id`=? and id = ?', [$c_id,$buID]);
        }
       else{

        $businessUnits = DB::select('SELECT * FROM `business_units` WHERE `company_id`='.$c_id.' and (`parent_bu_id` IN ('.$buID.') OR `id` = '.$buID.')');
       }






        // $businessUnits = DB::select('SELECT s.*,IFNULL(c.name,"System") as company FROM `business_units` s left join company c on s.company_id = c.id where company_id = ?', [$id]);
        return response()->json($businessUnits);
    }
    public function bu_responsible($c_id,$id)
    {
        $businessUnit = DB::select('SELECT * from business_units WHERE company_id =? and id=?',[$c_id,$id]);

        return response()->json($businessUnit);
    }
    public function update(Request $request, $id)
    {
        $data = $request->all();
        DB::update('UPDATE business_units SET company_id = ?, marketing_manager = ?, store_manager = ?, bu_user = ?, name = ?, email = ?, phone = ?, alternate_phone = ?, address_1 = ?, address_2 = ?, latitude = ?, longitude = ?, city = ?, state = ?, country = ?, zipcode = ?, status = ?, properties = ?,vendor_r = ?,customer_r=?,parent_bu_id=?,reponsible_user=?, ticket_represented = ? WHERE id = ?',
            [$data['company_id'], $data['marketing_manager'], $data['store_manager'], $data['bu_user'], $data['name'], $data['email'], $data['phone'], $data['alternate_phone'], $data['address_1'], $data['address_2'], $data['latitude'], $data['longitude'], $data['city'], $data['state'], $data['country'], $data['zipcode'], $data['status'], $data['properties'],  $data['vendor_r'],$data['customer_r'],$data['parent_bu_id'],$data['responsible'], $data['ticket_represented'] ?? '', $id]);



        return response()->json(['message' => 'Business unit updated successfully']);
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM business_units WHERE id = ?', [$id]);
        return response()->json(['message' => 'Business unit deleted successfully']);
    }
    public function dm_eligible($id)
    {
        $businessUnit = DB::select('SELECT c.*,d.eligible FROM company c
        JOIN domains d
        ON c.domain_id = d.id
        where c.id = ?;',[$id]);

        return response()->json($businessUnit);
    }
    
    public function deletebufields($id)
    {
        DB::delete('DELETE FROM `bu_fields` WHERE bu_id=?', [$id]);
        return response()->json(['message' => 'Business unit Fields deleted successfully']);
    }

    public function updatebustatus(Request $request)
    {
        $data = $request->all();
    
        DB::update('UPDATE business_units SET active = ? WHERE id = ?', [
            $data['active'],
            $data['id'],
        ]);
    
        return response()->json([
            'message' => 'Business Unit status updated successfully'
        ]);
    }
    
    
}
