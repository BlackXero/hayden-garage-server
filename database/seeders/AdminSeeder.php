<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = array(
            'first_name' => 'Paul',
            'last_name' => 'Paul',
            'is_admin' => 1,
            'email' => 'paul@admin.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make('123456'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
        DB::table('users')->insert($adminUser);
    }
}
