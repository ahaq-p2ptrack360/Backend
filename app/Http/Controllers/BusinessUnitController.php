<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BusinessUnitController extends Controller
{
    public function index()
    {
        $query = DB::table('business_units as s')->leftJoin('company as c', 's.company_id', '=', 'c.id')
            ->selectRaw('s.*, IFNULL(c.name, "System") as company');
        if ($this->tenantCompanyId() !== null) {
            $query->where('s.company_id', $this->tenantCompanyId());
        }
        $businessUnits = $query->get();
        return response()->json($businessUnits);
    }

    public function vendorbu($id)
    {
        $id = $this->tenantCompanyId() ?? $id;
        $businessUnits = DB::select('SELECT s.*,IFNULL(c.name,"System") as company FROM `business_units` s left join company c on s.company_id = c.id where vendor_r = "yes" and company_id = ?', [$id]);
        return response()->json($businessUnits);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['company_id'] = $this->tenantCompanyId() ?? $data['company_id'];

        DB::insert(
            'INSERT INTO business_units 
                (company_id, marketing_manager, store_manager, bu_user, name, email, phone, alternate_phone, 
                 address_1, address_2, latitude, longitude, city, state, country, zipcode, status, properties, 
                 vendor_r, customer_r, parent_bu_id, reponsible_user, ticket_represented) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $data['company_id'] ?? null,
                $data['marketing_manager'] ?? null,
                $data['store_manager'] ?? null,
                $data['bu_user'] ?? null,
                $data['name'] ?? '',
                $data['email'] ?? '',
                $data['phone'] ?? '',
                $data['alternate_phone'] ?? '',
                $data['address_1'] ?? '',
                $data['address_2'] ?? '',
                $data['latitude'] ?? '',
                $data['longitude'] ?? '',
                $data['city'] ?? '',
                $data['state'] ?? '',
                $data['country'] ?? '',
                $data['zipcode'] ?? '',
                $data['status'] ?? 1,
                $data['properties'] ?? '[]',
                $data['vendor_r'] ?? 'no',
                $data['customer_r'] ?? 'no',
                $data['parent_bu_id'] ?? null,
                $data['responsible'] ?? null,
                $data['ticket_represented'] ?? ''
            ]
        );

        $insertedId = DB::getPdo()->lastInsertId();

        DB::table('bu_group')->insert([
            'title' => 'Manager',
            'bu_id' => $insertedId,
            'company_id' => $data['company_id'],
            'created_by' => Auth::id(),
        ]);

        DB::table('bu_group')->insert([
            'title' => 'Staff',
            'bu_id' => $insertedId,
            'company_id' => $data['company_id'],
            'created_by' => Auth::id(),
        ]);

        if ($insertedId) {
            return response()->json([
                'message' => 'Business unit created successfully',
                'inserted_id' => $insertedId
            ]);
        }

        return response()->json(['message' => 'Failed to create business unit'], 500);
    }


    public function show($id)
    {
        $query = DB::table('business_units')->where('id', $id);
        if ($this->tenantCompanyId() !== null) {
            $query->where('company_id', $this->tenantCompanyId());
        }
        $businessUnit = $query->get();
        return response()->json($businessUnit);
    }
    public function companywise($id)
    {
        $id = $this->tenantCompanyId() ?? $id;
        $businessUnits = DB::select('SELECT s.*,IFNULL(c.name,"System") as company FROM `business_units` s left join company c on s.company_id = c.id where company_id = ?', [$id]);
        return response()->json($businessUnits);
    }

    public function companywise_by_company_r($id)
    {
        $id = $this->tenantCompanyId() ?? $id;
        $businessUnits = DB::select('SELECT s.*,IFNULL(c.name,"System") as company FROM `business_units` s left join company c on s.company_id = c.id where company_id = ? AND customer_r= "yes" ', [$id]);
        return response()->json($businessUnits);
    }
    public function parent_bu_wise($c_id,$buID,$group)
    {
         $c_id = $this->tenantCompanyId() ?? $c_id;
       $parent_bu= DB::select('SELECT parent_bu_id FROM `business_units` WHERE `company_id`=? AND business_units.id=?', [$c_id,$buID]) ;
       if (empty($parent_bu)) {
           return response()->json(['error' => 'Business unit not found'], 404);
       }
       $parent_bu_id = $parent_bu[0]->parent_bu_id;
       if($parent_bu_id==NULL){
        $businessUnits =DB::select('SELECT * FROM `business_units` WHERE `company_id`=?', [$c_id]);
       }
       else if($group == 'Staff'){
        $businessUnits =DB::select('SELECT * FROM `business_units` WHERE `company_id`=? and id = ?', [$c_id,$buID]);
        }
       else{

        $businessUnits = DB::select(
            'SELECT * FROM `business_units` WHERE `company_id` = ? AND (`parent_bu_id` = ? OR `id` = ?)',
            [$c_id, $buID, $buID]
        );
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
        $companyId = $this->tenantCompanyId() ?? ($data['company_id'] ?? null);
        $data['company_id'] = $companyId;

        DB::update(
            'UPDATE business_units SET 
                company_id = ?, 
                marketing_manager = ?, 
                store_manager = ?, 
                bu_user = ?, 
                name = ?, 
                email = ?, 
                phone = ?, 
                alternate_phone = ?, 
                address_1 = ?, 
                address_2 = ?, 
                latitude = ?, 
                longitude = ?, 
                city = ?, 
                state = ?, 
                country = ?, 
                zipcode = ?, 
                status = ?, 
                properties = ?, 
                vendor_r = ?, 
                customer_r = ?, 
                parent_bu_id = ?, 
                reponsible_user = ?, 
                ticket_represented = ? 
             WHERE id = ? AND company_id = ?',
            [
                $data['company_id'] ?? null,
                $data['marketing_manager'] ?? null,
                $data['store_manager'] ?? null,
                $data['bu_user'] ?? null,
                $data['name'] ?? '',
                $data['email'] ?? '',
                $data['phone'] ?? '',
                $data['alternate_phone'] ?? '',
                $data['address_1'] ?? '',
                $data['address_2'] ?? '',
                $data['latitude'] ?? '',
                $data['longitude'] ?? '',
                $data['city'] ?? '',
                $data['state'] ?? '',
                $data['country'] ?? '',
                $data['zipcode'] ?? '',
                $data['status'] ?? 1,
                $data['properties'] ?? '[]',
                $data['vendor_r'] ?? 'no',
                $data['customer_r'] ?? 'no',
                $data['parent_bu_id'] ?? null,
                $data['responsible'] ?? null,
                $data['ticket_represented'] ?? '',
                $id,
                $companyId
            ]
        );

        return response()->json(['message' => 'Business unit updated successfully']);
    }


    public function destroy($id)
    {
        $query = DB::table('business_units')->where('id', $id);
        if ($this->tenantCompanyId() !== null) {
            $query->where('company_id', $this->tenantCompanyId());
        }
        $deleted = $query->delete();
        if (!$deleted) {
            return response()->json(['error' => 'Business unit not found'], 404);
        }
        return response()->json(['message' => 'Business unit deleted successfully']);
    }
    public function dm_eligible($id)
    {
        $id = $this->tenantCompanyId() ?? $id;
        $businessUnit = DB::select('SELECT c.*,d.eligible FROM company c
        JOIN domains d
        ON c.domain_id = d.id
        where c.id = ?;',[$id]);

        return response()->json($businessUnit);
    }
    
    public function deletebufields($id)
    {
        if (!$this->businessUnitBelongsToTenant($id)) {
            return response()->json(['error' => 'Business unit not found'], 404);
        }
        DB::delete('DELETE FROM `bu_fields` WHERE bu_id=?', [$id]);
        return response()->json(['message' => 'Business unit Fields deleted successfully']);
    }

    public function updatebustatus(Request $request)
    {
        $data = $request->all();

        $query = DB::table('business_units')->where('id', $data['id']);
        if ($this->tenantCompanyId() !== null) {
            $query->where('company_id', $this->tenantCompanyId());
        }
        $query->update(['active' => $data['active']]);
    
        return response()->json([
            'message' => 'Business Unit status updated successfully'
        ]);
    }

    private function tenantCompanyId()
    {
        $request = app('request');
        return $request->attributes->get('tenant_platform_admin')
            ? null
            : $request->attributes->get('tenant_company_id');
    }

    private function businessUnitBelongsToTenant($id)
    {
        $query = DB::table('business_units')->where('id', $id);
        if ($this->tenantCompanyId() !== null) {
            $query->where('company_id', $this->tenantCompanyId());
        }
        return $query->exists();
    }
    
    
}
