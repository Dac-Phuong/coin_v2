<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);
        $role = ModelsRole::findByName('Super Admin'); 

        $permissions = ModelsPermission::all();

        $role->syncPermissions($permissions);
    }
}
