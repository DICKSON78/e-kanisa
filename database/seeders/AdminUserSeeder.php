<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the Mchungaji (Pastor) role
        $mchungajiRole = Role::where('slug', 'mchungaji')->first();

        if (!$mchungajiRole) {
            $this->command->error('Mchungaji role not found! Please run RoleSeeder first.');
            return;
        }

        // Create admin user
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@kanisa.org'],
            [
                'name' => 'Admin Kanisa',
                'email' => 'admin@kanisa.org',
                'password' => Hash::make('password'),
                'role_id' => $mchungajiRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@kanisa.org');
        $this->command->info('Password: password');
        $this->command->warn('Please change the password after first login!');

        // Create additional sample users for testing
        $mhasibuRole = Role::where('slug', 'mhasibu')->first();
        $mwanachamaRole = Role::where('slug', 'mwanachama')->first();

        if ($mhasibuRole) {
            User::updateOrCreate(
                ['email' => 'mhasibu@kanisa.org'],
                [
                    'name' => 'Mhasibu Kanisa',
                    'email' => 'mhasibu@kanisa.org',
                    'password' => Hash::make('password'),
                    'role_id' => $mhasibuRole->id,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
            $this->command->info('Accountant user created: mhasibu@kanisa.org / password');
        }

        if ($mwanachamaRole) {
            User::updateOrCreate(
                ['email' => 'member@kanisa.org'],
                [
                    'name' => 'Mwanachama Kanisa',
                    'email' => 'member@kanisa.org',
                    'password' => Hash::make('password'),
                    'role_id' => $mwanachamaRole->id,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
            $this->command->info('Member user created: member@kanisa.org / password');
        }
    }
}
