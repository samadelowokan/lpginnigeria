<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role' => 'ADMIN',
            'username' => 'admin',
            'email' => 'admin@lpg.com',
            'gender' => 'male',
            'phone_no' => "09099909988",
            'address' => '24 lpg avenue',
            'password' => bcrypt('adminlpg'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'role' => 'User',
            'username' => 'user',
            'email' => 'user@lpg.com',
            'gender' => 'male',
            'phone_no' => "09099909942",
            'address' => '24 lpg avenue',
            'password' => bcrypt('userlpg'),
            'email_verified_at' => now(),
        ]);
    }
}
