<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data_permissions = [
            'dashboard',

            'list-user',
            'create-user',
            'update-user',
            'delete-user',

            'list-role',
            'create-role',
            'update-role',
            'delete-role',

            'list-wallets',
            'create-wallets',
            'update-wallets',
            'delete-wallets',

            'list-investor',
            'create-investor',
            'update-investor',
            'delete-investor',

            'list-plan',
            'create-plan',
            'update-plan',
            'delete-plan',

            'list-deposit',
            'history-deposit',

            'list-withdraw',
            'history-withdraw',
            'list-referral',

            'list-coin',
            'create-coin',
            'update-coin',
            'delete-coin',

            'list-network',
            'create-network',
            'update-network',
            'delete-network',

            'list-coin',
            'create-coin',
            'update-coin',
            'delete-coin',

            'settings',
        ];
        foreach ($data_permissions as $value) {
            DB::table('permissions')->insert([
                'name' => $value,
                'guard_name' => 'web'
            ]);
        }
    }
}