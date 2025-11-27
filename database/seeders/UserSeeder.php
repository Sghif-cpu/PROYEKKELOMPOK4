<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing users
        User::truncate();

        // Create admin user
        User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@opus.com',
            'password' => 'password123', // Will be auto-hashed by model
            'role' => 'admin',
        ]);

        // Create doctor user
        User::create([
            'name' => 'Dokter Umum',
            'email' => 'dokter@opus.com',
            'password' => 'dokter123',
            'role' => 'dokter',
        ]);

        // Create laboratory staff
        User::create([
            'name' => 'Staff Laboratorium',
            'email' => 'lab@opus.com',
            'password' => 'lab123',
            'role' => 'laboratorium',
        ]);

        // Create cashier
        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@opus.com',
            'password' => 'kasir123',
            'role' => 'kasir',
        ]);

        $this->command->info('Users created successfully!');
        $this->command->info('Admin: admin@opus.com / password123');
        $this->command->info('Dokter: dokter@opus.com / dokter123');
        $this->command->info('Lab: lab@opus.com / lab123');
        $this->command->info('Kasir: kasir@opus.com / kasir123');
    }
}