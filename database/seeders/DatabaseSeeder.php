<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run seeders in the correct order
        // 1. Roles must be seeded first (required for users)
        $this->call(RoleSeeder::class);

        // 2. Settings for church configuration
        $this->call(SettingSeeder::class);

        // 3. Income categories
        $this->call(IncomeCategorySeeder::class);

        // 4. Expense categories
        $this->call(ExpenseCategorySeeder::class);

        // 5. Admin user (depends on roles)
        $this->call(AdminUserSeeder::class);

        // 6. Members data
        $this->call(MemberSeeder::class);

        // 7. Pledges data (depends on members, users)
        $this->call(PledgeSeeder::class);

        // 8. Pledge payments data (depends on pledges)
        $this->call(PledgePaymentSeeder::class);

        // 9. Income data (depends on members, categories, users)
        $this->call(IncomeSeeder::class);

        // 10. Expense data (depends on categories, users)
        $this->call(ExpenseSeeder::class);

        // 11. Events data (depends on users)
        $this->call(EventSeeder::class);

        // 12. Requests data (depends on users)
        $this->call(RequestSeeder::class);

        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('All seeders completed successfully!');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('------------------');
        $this->command->info('Admin (Pastor):     admin@kanisa.org / password');
        $this->command->info('Accountant:         mhasibu@kanisa.org / password');
        $this->command->info('Member:             member@kanisa.org / password');
        $this->command->info('');
        $this->command->warn('IMPORTANT: Please change these passwords after first login!');
        $this->command->info('');
        $this->command->info('Database Statistics:');
        $this->command->info('------------------');
        $this->command->info('✓ 10 Wanachama (Members)');
        $this->command->info('✓ 19 Ahadi (Pledges)');
        $this->command->info('✓ 36 Malipo ya Ahadi (Pledge Payments)');
        $this->command->info('✓ 50+ Rekodi za Mapato (Income Records)');
        $this->command->info('✓ 60+ Rekodi za Matumizi (Expense Records)');
        $this->command->info('✓ 14 Matukio (Events)');
        $this->command->info('✓ 11 Maombi (Requests)');
        $this->command->info('');
    }
}
