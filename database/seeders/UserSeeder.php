<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'id' => 1,
            'name' => 'Administrator',
            'email' => 'smp1turi@gmail.com',
            'password' => bcrypt('smp1turi'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}
