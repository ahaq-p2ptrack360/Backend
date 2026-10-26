<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Concerns\ScopesTenantCompanyData;

class BuFieldController extends Controller
{
    use ScopesTenantCompanyData;

    public function index()
    {
        $query = DB::table('bu_fields as f')->join('business_units as b', 'b.id', '=', 'f.bu_id')
            ->select('f.*');
        $companyId = $this->tenantCompanyId();
        if ($companyId !== null && (int) $companyId !== 0) {
            $query->where('b.company_id', $companyId);
        }
        $buFields = $query->get();
        return response()->json($buFields);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'type' => 'required|string|max:100', 'bu_id' => 'required|integer']);
        if (!$this->ownsBu($data['bu_id'])) {
            return response()->json(['message' => 'Business unit not found'], 404);
        }

        DB::insert(
            'INSERT INTO bu_fields (name, type, bu_id) VALUES (?, ?, ?)',
            [$data['name'], $data['type'], $data['bu_id']]
        );

        return response()->json(['message' => 'Business Unit Field created successfully']);
    }
    public function bu_field_data(Request $request)
    {
        $data = $request->validate(['field_id' => 'required|integer', 'bu_id' => 'required|integer', 'Ticket_id' => 'required|integer', 'field_data' => 'nullable|string']);
        $companyId = $this->tenantCompanyId();
        $field = DB::table('bu_fields')->where('id', $data['field_id'])->where('bu_id', $data['bu_id'])->exists();
        $ticketQuery = DB::table('tickets')->where('id', $data['Ticket_id'])->where('business_unit_id', $data['bu_id']);
        if ($companyId !== null && (int) $companyId !== 0) {
            $ticketQuery->where('company_id', $companyId);
        }
        if (!$field || !$this->ownsBu($data['bu_id']) || !$ticketQuery->exists()) {
            return response()->json(['message' => 'Field, business unit, or ticket not found'], 404);
        }

        DB::insert(
            'INSERT INTO `bu_field_data`( `field_id`, `bu_id`, `Ticket_id`, `field_data`) VALUES (?, ?, ?,?)',
            [$data['field_id'], $data['bu_id'], $data['Ticket_id'],$data['field_data']]
        );

        return response()->json(['message' => 'Business Unit Field Data created successfully']);
    }

    public function show($id)
    {
        if (!$this->ownsBu($id)) {
            return response()->json(['message' => 'Business unit not found'], 404);
        }
        $buField = DB::table('bu_fields')->where('bu_id', $id)->get();
        return response()->json($buField);
    }

    public function destroy($id)
    {
        if (!$this->ownsBu($id)) {
            return response()->json(['message' => 'Business unit not found'], 404);
        }
        DB::table('bu_fields')->where('bu_id', $id)->delete();
        return response()->json(['message' => 'Business Unit Field deleted successfully']);
    }

    private function ownsBu($businessUnitId)
    {
        $query = DB::table('business_units')->where('id', $businessUnitId);
        $companyId = $this->tenantCompanyId();
        if ($companyId !== null && (int) $companyId !== 0) {
            $query->where('company_id', $companyId);
        }
        return $query->exists();
    }
}
