<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\State;
use App\Models\Zone;
use App\Models\Lga;
use App\Models\Ward;
use App\Models\Pu;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleId = Role::where('name', 'super')->first()?->id;
        $stateId = State::where('name', 'Bauchi')->first()?->id;
        $zoneId  = null;
        $lgaId   = null;
        $wardId  = null;
        $puId    = null;

        User::updateOrCreate([
            'name' => 'Aliyu Abubakar',
            'username' => 'aliyufari',
            'email' => 'aliyufari@gmail.com',
            'password' => Hash::make('password'),
            'image' => null,
            'role_id' => $roleId,
            'state_id' => $stateId,
            'zone_id' => $zoneId,
            'lga_id' => $lgaId,
            'ward_id' => $wardId,
            'pu_id' => $puId,
            'company' => 'Admin Company',
            'job' => 'Administrator',
            'country' => 'Nigeria',
            'address' => 'Abuja, Nigeria',
            'phone' => '08012345678',
            'facebook' => null,
            'twitter' => null,
            'instagram' => null,
            'youtube' => null,
            'description' => 'Super user with all permissions',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        User::updateOrCreate([
            'name' => 'Aliyu Muhammad Sadisu',
            'username' => 'asadis',
            'email' => 'aslere00005@gmail.com',
            'password' => Hash::make('password'),
            'image' => null,
            'role_id' => $roleId,
            'state_id' => $stateId,
            'zone_id' => $zoneId,
            'lga_id' => $lgaId,
            'ward_id' => $wardId,
            'pu_id' => $puId,
            'company' => 'Admin Company',
            'job' => 'Administrator',
            'country' => 'Nigeria',
            'address' => 'Abuja, Nigeria',
            'phone' => '08012345678',
            'facebook' => null,
            'twitter' => null,
            'instagram' => null,
            'youtube' => null,
            'description' => 'Super user with all permissions',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
