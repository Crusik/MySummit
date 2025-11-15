<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Delete all users first (without truncating to avoid FK errors)
        User::query() -> delete();

        // Create the current user (patient)
        $patient = User::create([
            'name' => 'Michael Anderson',
            'email' => 'michael@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Create medical professionals
        $drSmith = User::create([
            'name' => 'Dr. Smith',
            'email' => 'dr.smith@example.com',
            'password' => Hash::make('password123'),
        ]);

        $nurseTaylor = User::create([
            'name' => 'Nurse Taylor',
            'email' => 'nurse.taylor@example.com',
            'password' => Hash::make('password123'),
        ]);

        $drJohnson = User::create([
            'name' => 'Dr. Johnson',
            'email' => 'dr.johnson@example.com',
            'password' => Hash::make('password123'),
        ]);

        $nutritionist = User::create([
            'name' => 'Lisa Chen',
            'email' => 'lisa.chen@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
