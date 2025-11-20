<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'super',
            'admin',
            'user',
            'ratech',
            'supervisor',
            'state_coodinator',
            'lga_coodinator'
        ];

        foreach ($roles as $roleName) {
            Role::updateOrCreate(['name' => $roleName], ['name' => $roleName]);
        }
    }
}
