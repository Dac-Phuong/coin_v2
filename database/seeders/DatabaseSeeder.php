<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = config('permissions');
        $list_permissions = [];
        if (!empty($permissions)) {
            foreach ($permissions as $item) {
                foreach ($item['permissions'] as $permission) {
                    $list_permissions[] = $permission;
                }
            }
        }
        if (!empty($list_permissions)) {
            foreach ($list_permissions as $permission => $name) {
                DB::table('permissions')->insert([
                    'name' => $name,
                    'guard_name' => 'web'
                ]);
            }
        }
        // create role
        DB::table('roles')->insert([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);
        // create role member
        DB::table('roles')->insert([
            'name' => 'Member',
            'guard_name' => 'web',
        ]);
        $role = Role::findByName('Super Admin');
        $permissions = Permission::all();
        $role->syncPermissions($permissions);

        // create admin
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'Super Admin',
        ]);
        $user = User::where('email', 'admin@gmail.com')->first();
        if ($user) {
            $role = Role::firstOrCreate(['name' => 'Super Admin']);
            $user->assignRole($role);
        } else {
            throw new \Exception('User not found.');
        }
    }
}
