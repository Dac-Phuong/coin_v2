<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = config('permissions');
        return view('admin.user-management.roles.index', ['data' => $permissions]);
    }

    public function getRoles()
    {
        $roles = Role::with('users')->orderBy('created_at', 'ASC')->get();
        return response()->json([
            'error_code' => 0,
            'data' => [
                'roles' => $roles,
                'can_create' => Gate::allows('create-role'),
                'can_update' => Gate::allows('update-role'),
                'can_delete' => Gate::allows('delete-role')
            ],
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|string|unique:roles,name',
        ]);
        try {
            if ($validator->fails()) {
                return response()->json([
                    'error_code' => 1,
                    'message' => trans('Invalid data'),
                    'error' => $validator->errors()->first()
                ]);
            }

            $role = Role::create(['name' => $request->role]);
            $role->syncPermissions($request->permissions);
            return response()->json([
                'error_code' => 0,
                'message' => trans('Add success!')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error_code' => 1,
                'message' => trans('Add failed!')
            ]);
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => ['required', 'string', 'unique:roles,name,' . $request->role_id],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error_code' => 1,
                'message' => trans('Invalid data'),
                'error' => $validator->errors()->first()
            ]);
        }
        try {
            $role = Role::find($request->role_id);
            if (!$role) {
                return response()->json([
                    'error_code' => 1,
                    'message' => trans('Role not found')
                ]);
            }
            $role->name = $request->role;
            $role->save();
            $role->syncPermissions($request->permissions);
            return response()->json([
                'error_code' => 0,
                'message' => trans('Update success!')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error_code' => 1,
                'message' => trans('Update failed!')
            ]);
        }
    }
    public function show(string $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json([
                'error_code' => 1,
                'message' => trans('Role not found')
            ]);
        }
        $permissions = $role->permissions->pluck('name')->toArray();
        return response()->json([
            'error_code' => 0,
            'data' => [
                'role' => $role,
                'permissions' => $permissions,
            ]
        ]);
    }

    public function destroy(string $id)
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                return response()->json([
                    'error_code' => 1,
                    'message' => trans('Role not found')
                ]);
            }
            if ($role->name == "Super Admin") {
                return response()->json([
                    'error_code' => 1,
                    'message' => trans('Cannot delete this role')
                ]);
            }
            $role->delete();
            return response()->json([
                'error_code' => 0,
                'message' => trans('Delete success!')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error_code' => 1,
                'message' => trans('Delete failed!')
            ]);
        }
    }
}
