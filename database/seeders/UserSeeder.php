<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        DB::table('users')->insert([
            'first_name' => 'e-Appointment',
            'last_name' => 'Admin',
            'phone' => '02-272-8901',
            'email' => 'appoinment@rd.go.th',
            'password' => Hash::make('p@ssw0rd'),
        ]);
        */
        $role = Role::where('name','admin')->first();

        $user = new User();
        $user->first_name = 'e-Appointment';
        $user->last_name = 'Admin';
        $user->phone = '02-272-8901';
        $user->email = 'appoinment@rd.go.th';
        $user->password = Hash::make('p@ssw0rd');
        $user->role_id = $role->id;
        $user->save();
    }
}
