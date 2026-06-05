<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = DB::select('SELECT * FROM permissions');
        return response()->json($permissions);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        DB::insert('INSERT INTO permissions (title) VALUES (?)',
            [$data['title']]);

        return response()->json(['message' => 'Permission created successfully']);
    }

    public function show($id)
    {
        $permission = DB::select('SELECT * FROM role_permissions WHERE role_id = ?', [$id]);
        return response()->json($permission);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        DB::update('UPDATE permissions SET title = ? WHERE id = ?', [$data['title'], $id]);

        return response()->json(['message' => 'Permission updated successfully']);
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM permissions WHERE id = ?', [$id]);
        return response()->json(['message' => 'Permission deleted successfully']);
    }

    
    public function storepermission(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|integer|exists:roles,id',
            'permissions' => 'required|array',
            'permissions.*.page' => 'required|string',
            'permissions.*.create' => 'nullable|in:0,1',
            'permissions.*.read' => 'nullable|in:0,1',
            'permissions.*.update' => 'nullable|in:0,1',
            'permissions.*.delete' => 'nullable|in:0,1',
        ]);
    
        $roleId = $validated['role_id'];
        $permissionsList = $validated['permissions'];
    
        // Allowed page keys (must match your columns)
        $allowedPages = [
            'types', 'status', 'priority', 'impact', 'business_unit',
            'assign_group', 'create_group', 'vendor', 'subscription',
            'ticket', 'report', 'domain', 'company', 'user', 'account', 'designation','qutation'
        ];
    
        // Build per-page permission payload
        $perPageData = [];
        foreach ($permissionsList as $p) {
            $page = $p['page'];
            if (!in_array($page, $allowedPages)) {
                continue; // skip unexpected
            }
            $perPageData[$page] = [
                'create' => isset($p['create']) ? (int)$p['create'] : 0,
                'read'   => isset($p['read']) ? (int)$p['read'] : 0,
                'update' => isset($p['update']) ? (int)$p['update'] : 0,
                'delete' => isset($p['delete']) ? (int)$p['delete'] : 0,
            ];
        }
    
        // Prepare JSON for only provided pages
        $columnsAndJson = [];
        foreach ($perPageData as $pageKey => $perm) {
            $columnsAndJson[$pageKey] = json_encode($perm);
        }
    
        DB::beginTransaction();
        try {
            $existing = DB::select('SELECT id FROM role_permissions WHERE role_id = ?', [$roleId]);
    
            if (count($existing) > 0) {
                // Update existing record
                $setParts = [];
                $bindings = [];
                foreach ($columnsAndJson as $col => $json) {
                    $setParts[] = "`{$col}` = ?";
                    $bindings[] = $json;
                }
                if (!empty($setParts)) {
                    $setClause = implode(', ', $setParts);
                    $bindings[] = $roleId; // for WHERE
                    $sql = "UPDATE role_permissions SET {$setClause}, updated_at = CURRENT_TIMESTAMP WHERE role_id = ?";
                    DB::update($sql, $bindings);
                }
            } else {
                // Insert new record
                $colNames = ['role_id'];
                $placeholders = ['?'];
                $insertBindings = [$roleId];
    
                foreach ($columnsAndJson as $col => $json) {
                    $colNames[] = "`{$col}`";
                    $placeholders[] = '?';
                    $insertBindings[] = $json;
                }
    
                // Let created_at and updated_at default to CURRENT_TIMESTAMP if your schema does that.
                $cols = implode(', ', $colNames);
                $vals = implode(', ', $placeholders);
                $sql = "INSERT INTO role_permissions ({$cols}) VALUES ({$vals})";
                DB::insert($sql, $insertBindings);
            }
    
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to save permissions.',
                'error' => $e->getMessage()
            ], 500);
        }
    
        return response()->json([
            'message' => 'Permissions saved for role.',
            'role_id' => $roleId,
        ]);
    }
    

}
