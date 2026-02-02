<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Enums\Role as RoleEnum;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RoleEnum::cases() as $role) {
            Role::updateOrCreate(['name' => $role]);
        }
    }
}
