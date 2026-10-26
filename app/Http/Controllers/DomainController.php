<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Concerns\ScopesTenantCompanyData;

class DomainController extends Controller
{
    use ScopesTenantCompanyData;

    public function index()
    {
        $domains = DB::select('SELECT * FROM domains where active =1');
        return response()->json($domains);
    }

    public function store(Request $request)
    {
        if (!$this->isPlatformAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $data = $request->validate(['title' => 'required|string|max:255', 'status' => 'required', 'eligible' => 'required']);

        DB::insert('INSERT INTO domains (title, status,eligible) VALUES (?, ?,?)',
            [$data['title'], $data['status'], $data['eligible']]);
            $insertedId = DB::getPdo()->lastInsertId();

            return response()->json(['message' => 'Domain created successfully', 'inserted_id' => $insertedId]);
        
    }

    public function show($id)
    {
        $domain = DB::select('SELECT * FROM domains WHERE id = ? ', [$id]);
        return response()->json($domain);
    }

    public function update(Request $request, $id)
    {
        if (!$this->isPlatformAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $data = $request->validate(['title' => 'required|string|max:255', 'status' => 'required']);

        DB::update('UPDATE domains SET title = ?, status = ? WHERE id = ?', [$data['title'], $data['status'], $id]);

        return response()->json(['message' => 'Domain updated successfully']);
    }

    public function destroy($id)
    {
        if (!$this->isPlatformAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        DB::delete('DELETE FROM domains WHERE id = ?', [$id]);
        return response()->json(['message' => 'Domain deleted successfully']);
    }
    public function domainstore(Request $request)
    {
        if (!$this->isPlatformAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $data = $request->validate(['domain_id' => 'required|integer|exists:domains,id', 'name' => 'required|string|max:255', 'type' => 'required|string|max:100']);

        DB::insert(
            'INSERT INTO `domain_fields`(`domain_id`, `name`, `type`) VALUES (?,?,?)',
            [$data['domain_id'],$data['name'], $data['type']]
        );

        return response()->json(['message' => 'Domain Field created successfully']);
    }
    public function domain_fields($id)
    {
        if (!DB::table('domains')->where('id', $id)->exists()) {
            return response()->json(['message' => 'Domain not found'], 404);
        }
        $domain_fields = DB::select('SELECT * FROM `domain_fields` WHERE domain_id=?', [$id]);
        return response()->json($domain_fields);
    }

    public function domain_field_datastore(Request $request)
    {
        $data = $request->validate(['field_id' => 'required|integer', 'domain_id' => 'required|integer|exists:domains,id', 'company_id' => 'nullable|integer', 'field_data' => 'nullable|string']);
        $companyId = $this->tenantCompanyId($data['company_id'] ?? null);
        if ($companyId === null) {
            return response()->json(['message' => 'Company is required'], 422);
        }
        if (!DB::table('domain_fields')->where('id', $data['field_id'])->where('domain_id', $data['domain_id'])->exists()) {
            return response()->json(['message' => 'Domain field not found'], 404);
        }
        DB::insert(
            'INSERT INTO `domain_field_data`(`field_id`, `domain_id`, `company_id`, `field_data`) VALUES (?,?,?,?)',
            [$data['field_id'], $data['domain_id'], $companyId, $data['field_data'] ?? null]
        );

        return response()->json(['message' => 'Domain Field Data created successfully']);
    }

    public function updatedoaminstatus(Request $request)
{
    if (!$this->isPlatformAdmin()) {
        return response()->json(['message' => 'Forbidden'], 403);
    }
    $data = $request->validate(['active' => 'required|boolean', 'id' => 'required|integer']);

    DB::update(
        'UPDATE domains SET active = ? WHERE id = ?',
        [$data['active'], $data['id']]
    );

    return response()->json([
        'success' => true,
        'message' => 'Domain status updated successfully'
    ]);
    }

    private function isPlatformAdmin()
    {
        return Auth::user() && (int) Auth::user()->company_id === 0;
    }
}

