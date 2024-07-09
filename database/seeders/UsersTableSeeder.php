<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Ensure roles exist
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'web']
        );
        $userRole = Role::firstOrCreate(
            ['name' => 'user', 'guard_name' => 'web']
        );

        // Create admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'balance' => 0, // Balance field is irrelevant for admin
        ]);
        $admin->assignRole($adminRole);

        // Create regular user
        $user = User::firstOrCreate([
            'email' => 'user@example.com',
        ], [
            'name' => 'Regular User',
            'password' => Hash::make('password'),
            'balance' => 500, // Initial balance for regular user
        ]);
        $user->assignRole($userRole);
    }
}
