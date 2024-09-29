<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public $model;
    function __construct()
    {
        $this->model = new User();
    }
    public function index()
    {
        $list_role = Role::get();
        return view('admin.user-management.users.index', ['list_role' => $list_role]);
    }
    public function filterDataTable(Request $request)
    {
        $data = $request->all();
        // Page Length
        $pageNumber = ($data['start'] / $data['length']) + 1;
        $pageLength = $data['length'] ?? 10;
        $skip = ($pageNumber - 1) * $pageLength;
        // Page Order
        $orderColumnIndex = $data['order'][0]['column'] ?? '0';
        $orderByColumn = $data['columns'][$orderColumnIndex]['data'] ?? 'id';
        $orderType = $data['order'][0]['dir'] ?? 'desc';
        $query = $this->model->query();
        // Search
        $search = $data['search']['value'] ?? '';
        if (isset($search)) {
            $query = $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('role', 'like', '%' . $search . '%');
            });
        }
        $query = $query->orderBy($orderByColumn, $orderType);
        $recordsFiltered = $recordsTotal = $query->count();
        $result = $query
            ->where('email', '!=', 'admin@gmail.com')
            ->skip($skip)
            ->take($pageLength)
            ->get();
        return [
            'draw' => $data['draw'],
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $result,
            'role' => [
                'can_create' => Gate::allows('create-user'),
                'can_update' => Gate::allows('update-user'),
                'can_delete' => Gate::allows('delete-user'),
            ],
        ];
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error_code' => 1,
                'message' => 'User created failed',
                'error' => $validator->errors()->first(),
            ], 200);
        }
        try {
            $user = User::create($request->all());
            $user->assignRole($request->role);
            return response()->json([
                'error_code' => 0,
                'message' => 'User created successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error_code' => 1,
                'message' => 'User created failed',
            ], 200);
        }
    }


    public function update(Request $request)
    {
        $id = $request->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error_code' => 1,
                'message' => 'User updated failed',
                'error' => $validator->errors()->first(),
            ], 200);
        }
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'error_code' => 1,
                    'message' => 'User not found',
                ], 200);
            }
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->save();
            if ($request->role) {
                $user->roles()->detach();
                $user->assignRole($request->role);
            }
            return response()->json([
                'error_code' => 0,
                'message' => 'User updated successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error_code' => 1,
                'message' => 'User updated failed',
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $user = User::find($request->id);
            if (!$user) {
                return response()->json([
                    'error_code' => 1,
                    'message' => 'User not found',
                ], 200);
            }
            if ($user->email == 'admin@gmail.com') {
                return response()->json([
                    'error_code' => 1,
                    'message' => 'User deleted failed',
                ], 200);
            }
            $user->delete();
            return response()->json([
                'error_code' => 0,
                'message' => 'User deleted successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error_code' => 1,
                'message' => 'User deleted failed',
            ], 200);
        }
    }
}
