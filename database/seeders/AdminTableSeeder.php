<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Admin::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@homer.com',
            'password' =>bcrypt('password')
        ]);
    }
}
