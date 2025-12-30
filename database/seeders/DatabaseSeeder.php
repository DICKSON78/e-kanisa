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
        $year = date('Y');

        // Run seeders in the correct order
        // 1. Roles must be seeded first (required for users)
        $this->call(RoleSeeder::class);

        // 2. Settings for church configuration
        $this->call(SettingSeeder::class);

        // 3. Income categories
        $this->call(IncomeCategorySeeder::class);

        // 4. Expense categories
        $this->call(ExpenseCategorySeeder::class);

        // 5. Jumuiyas (required for members)
        $this->call(JumuiyaSeeder::class);

        // 6. Admin and member users (depends on roles)
        $this->call(AdminUserSeeder::class);

        // 7. Members data (depends on users and jumuiyas)
        $this->call(MemberSeeder::class);

        // 8. Departments
        $this->call(DepartmentSeeder::class);

        // 9. Pledges data (depends on members, users)
        $this->call(PledgeSeeder::class);

        // 10. Pledge payments data (depends on pledges)
        $this->call(PledgePaymentSeeder::class);

        // 11. Income data (depends on members, categories, users)
        $this->call(IncomeSeeder::class);

        // 12. Expense data (depends on categories, users)
        $this->call(ExpenseSeeder::class);

        // 13. Events data (depends on users)
        $this->call(EventSeeder::class);

        // 14. Requests data (depends on users)
        $this->call(RequestSeeder::class);

        // 15. Pastoral Services data (depends on members, users)
        $this->call(PastoralServiceSeeder::class);

        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('   KKKT AGAPE - Database Seeded!');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('Taarifa za Kuingia (Login Credentials):');
        $this->command->info('----------------------------------------');
        $this->command->info('');
        $this->command->info('MCHUNGAJI (Admin):');
        $this->command->info('   Namba ya Kadi: KKKT-AGAPE-' . $year . '-0001');
        $this->command->info('   Nenosiri: mwakasege');
        $this->command->info('');
        $this->command->info('MHASIBU (Accountant):');
        $this->command->info('   Namba ya Kadi: KKKT-AGAPE-' . $year . '-0002');
        $this->command->info('   Nenosiri: kimaro');
        $this->command->info('');
        $this->command->info('WANACHAMA (Members):');
        $this->command->info('   KKKT-AGAPE-' . $year . '-0003 / mwangi');
        $this->command->info('   KKKT-AGAPE-' . $year . '-0004 / moshi');
        $this->command->info('   KKKT-AGAPE-' . $year . '-0005 / komba');
        $this->command->info('   KKKT-AGAPE-' . $year . '-0006 / massawe');
        $this->command->info('   KKKT-AGAPE-' . $year . '-0007 / mwakyembe');
        $this->command->info('   KKKT-AGAPE-' . $year . '-0008 / ndunguru');
        $this->command->info('   KKKT-AGAPE-' . $year . '-0009 / msuya');
        $this->command->info('   KKKT-AGAPE-' . $year . '-0010 / kilave');
        $this->command->info('   KKKT-AGAPE-' . $year . '-0011 / lyatuu');
        $this->command->info('   KKKT-AGAPE-' . $year . '-0012 / swai');
        $this->command->info('');
        $this->command->warn('MUHIMU: Tafadhali badilisha nenosiri baada ya kuingia mara ya kwanza!');
        $this->command->info('');
        $this->command->info('Takwimu za Database:');
        $this->command->info('--------------------');
        $this->command->info('   12 Wanachama (Members)');
        $this->command->info('   5 Jumuiya');
        $this->command->info('   Ahadi na Malipo');
        $this->command->info('   Mapato na Matumizi');
        $this->command->info('   Matukio na Maombi');
        $this->command->info('   Huduma za Kichungaji');
        $this->command->info('');
    }
}
