<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmergencyUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@opus.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        echo "User admin created:\n";
        echo "Email: admin@opus.com\n";
        echo "Password: password\n";
    }
}