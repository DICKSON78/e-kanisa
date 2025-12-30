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
     * Creates users with member number format (KKKT-AGAPE-YYYY-NNNN) as email
     */
    public function run(): void
    {
        // Get roles
        $mchungajiRole = Role::where('slug', 'mchungaji')->first();
        $mhasibuRole = Role::where('slug', 'mhasibu')->first();
        $mwanachamaRole = Role::where('slug', 'mwanachama')->first();

        if (!$mchungajiRole) {
            $this->command->error('Mchungaji role not found! Please run RoleSeeder first.');
            return;
        }

        $year = date('Y');

        // Create Mchungaji (Pastor/Admin) user
        // Member Number: KKKT-AGAPE-2025-0001
        // Password: mwakasege (last name lowercase)
        $adminUser = User::updateOrCreate(
            ['email' => 'KKKT-AGAPE-' . $year . '-0001@kkkt-agape.org'],
            [
                'name' => 'Mchungaji Joseph Mwakasege',
                'email' => 'KKKT-AGAPE-' . $year . '-0001@kkkt-agape.org',
                'password' => Hash::make('mwakasege'),
                'role_id' => $mchungajiRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('');
        $this->command->info('Pastor/Admin user created:');
        $this->command->info('   Namba ya Kadi: KKKT-AGAPE-' . $year . '-0001');
        $this->command->info('   Nenosiri: mwakasege');

        // Create Mhasibu (Accountant) user
        // Member Number: KKKT-AGAPE-2025-0002
        // Password: kimaro (last name lowercase)
        if ($mhasibuRole) {
            $mhasibuUser = User::updateOrCreate(
                ['email' => 'KKKT-AGAPE-' . $year . '-0002@kkkt-agape.org'],
                [
                    'name' => 'Grace Neema Kimaro',
                    'email' => 'KKKT-AGAPE-' . $year . '-0002@kkkt-agape.org',
                    'password' => Hash::make('kimaro'),
                    'role_id' => $mhasibuRole->id,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
            $this->command->info('');
            $this->command->info('Accountant user created:');
            $this->command->info('   Namba ya Kadi: KKKT-AGAPE-' . $year . '-0002');
            $this->command->info('   Nenosiri: kimaro');
        }

        // Create Mwanachama (Member) users
        // Member Numbers: KKKT-AGAPE-2025-0003 to KKKT-AGAPE-2025-0012
        $members = [
            ['name' => 'John Peter Mwangi', 'password' => 'mwangi'],
            ['name' => 'Sarah Elizabeth Moshi', 'password' => 'moshi'],
            ['name' => 'Emmanuel Joseph Komba', 'password' => 'komba'],
            ['name' => 'Agnes Maria Massawe', 'password' => 'massawe'],
            ['name' => 'Joshua Samuel Mwakyembe', 'password' => 'mwakyembe'],
            ['name' => 'Grace Neema Ndunguru', 'password' => 'ndunguru'],
            ['name' => 'Peter Daniel Msuya', 'password' => 'msuya'],
            ['name' => 'Joyce Ester Kilave', 'password' => 'kilave'],
            ['name' => 'Michael George Lyatuu', 'password' => 'lyatuu'],
            ['name' => 'Ruth Anna Swai', 'password' => 'swai'],
        ];

        if ($mwanachamaRole) {
            $this->command->info('');
            $this->command->info('Member users created:');

            foreach ($members as $index => $member) {
                $memberNumber = sprintf('%04d', $index + 3); // Start from 0003
                User::updateOrCreate(
                    ['email' => 'KKKT-AGAPE-' . $year . '-' . $memberNumber . '@kkkt-agape.org'],
                    [
                        'name' => $member['name'],
                        'email' => 'KKKT-AGAPE-' . $year . '-' . $memberNumber . '@kkkt-agape.org',
                        'password' => Hash::make($member['password']),
                        'role_id' => $mwanachamaRole->id,
                        'is_active' => true,
                        'email_verified_at' => now(),
                    ]
                );
                $this->command->info('   KKKT-AGAPE-' . $year . '-' . $memberNumber . ' / ' . $member['password']);
            }
        }

        $this->command->info('');
        $this->command->warn('MUHIMU: Tafadhali badilisha nenosiri baada ya kuingia mara ya kwanza!');
    }
}
