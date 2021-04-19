<?php

namespace Database\Seeders;

use App\Models\Agent;
use Illuminate\Database\Seeder;

class AgentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Agent::create([
            'first_name' => 'agent',
            'last_name' => 'agent',
            'email' => 'agent@homer.com',
            'password' =>bcrypt('password')
        ]);
    }
}
