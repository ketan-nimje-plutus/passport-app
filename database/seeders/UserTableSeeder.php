<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456789'),
            ], [
                'name' => 'demo',
                'email' => 'demo@admin.com',
                'password' => bcrypt('123456789'),
            ],
            [
                'name' => 'test',
                'email' => 'test@admin.com',
                'password' => bcrypt('123456789'),
            ]
        ]);
    }
}
