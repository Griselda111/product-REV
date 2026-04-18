<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@bpttg.go.id',
            'password' => bcrypt('admin123'),
            'role' => 2, // ADMIN
            'is_verified' => true
        ]);
    }
}
