<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pledge;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;

class PledgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user for created_by
        $adminUser = User::where('email', 'admin@kanisa.org')->first();
        $createdBy = $adminUser ? $adminUser->id : 1;

        // Get all members
        $members = Member::all();

        $pledgeTypes = [
            'Kiwanja 2025',
            'Usiku wa Agape 2025',
            'Mavuno 2025',
            'Ujenzi Kanisa 2025',
            'Miradi Maalum 2025',
        ];

        $pledges = [];

        // Member 1: John Mwangi (MEM2025001) - Has multiple pledges, some completed
        $pledges[] = [
            'member_id' => $members[0]->id,
            'pledge_type' => 'Kiwanja 2025',
            'amount' => 500000,
            'amount_paid' => 500000, // Fully paid
            'pledge_date' => Carbon::create(2025, 1, 5),
            'due_date' => Carbon::create(2025, 12, 31),
            'status' => 'Completed',
            'notes' => 'Ahadi ya mchango wa kiwanja 2025 - Imelipwa kikamilifu',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 1, 5),
            'updated_at' => Carbon::now(),
        ];

        $pledges[] = [
            'member_id' => $members[0]->id,
            'pledge_type' => 'Mavuno 2025',
            'amount' => 300000,
            'amount_paid' => 150000, // Partially paid
            'pledge_date' => Carbon::create(2025, 2, 10),
            'due_date' => Carbon::create(2025, 6, 30),
            'status' => 'Partial',
            'notes' => 'Ahadi ya sherehe ya mavuno - Amelipa nusu',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 2, 10),
            'updated_at' => Carbon::now(),
        ];

        // Member 2: Sarah Moshi (MEM2025002) - Active pledges with partial payments
        $pledges[] = [
            'member_id' => $members[1]->id,
            'pledge_type' => 'Usiku wa Agape 2025',
            'amount' => 750000,
            'amount_paid' => 250000, // Partially paid
            'pledge_date' => Carbon::create(2025, 1, 15),
            'due_date' => Carbon::create(2025, 11, 30),
            'status' => 'Partial',
            'notes' => 'Ahadi ya sherehe ya usiku wa Agape',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 1, 15),
            'updated_at' => Carbon::now(),
        ];

        $pledges[] = [
            'member_id' => $members[1]->id,
            'pledge_type' => 'Ujenzi Kanisa 2025',
            'amount' => 1000000,
            'amount_paid' => 400000, // Partially paid
            'pledge_date' => Carbon::create(2025, 2, 1),
            'due_date' => Carbon::create(2025, 12, 31),
            'status' => 'Partial',
            'notes' => 'Ahadi ya ujenzi wa kanisa',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 2, 1),
            'updated_at' => Carbon::now(),
        ];

        // Member 3: Emmanuel Komba (MEM2025003) - Student, smaller pledges
        $pledges[] = [
            'member_id' => $members[2]->id,
            'pledge_type' => 'Mavuno 2025',
            'amount' => 100000,
            'amount_paid' => 50000, // Partially paid
            'pledge_date' => Carbon::create(2025, 2, 15),
            'due_date' => Carbon::create(2025, 6, 30),
            'status' => 'Partial',
            'notes' => 'Ahadi ya sherehe ya mavuno - Mwanafunzi',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 2, 15),
            'updated_at' => Carbon::now(),
        ];

        // Member 4: Agnes Massawe (MEM2025004) - Widow, some completed pledges
        $pledges[] = [
            'member_id' => $members[3]->id,
            'pledge_type' => 'Kiwanja 2025',
            'amount' => 600000,
            'amount_paid' => 600000, // Fully paid
            'pledge_date' => Carbon::create(2025, 1, 8),
            'due_date' => Carbon::create(2025, 12, 31),
            'status' => 'Completed',
            'notes' => 'Ahadi ya kiwanja - Imelipwa kikamilifu',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 1, 8),
            'updated_at' => Carbon::now(),
        ];

        $pledges[] = [
            'member_id' => $members[3]->id,
            'pledge_type' => 'Miradi Maalum 2025',
            'amount' => 200000,
            'amount_paid' => 0, // Not yet paid
            'pledge_date' => Carbon::create(2025, 3, 1),
            'due_date' => Carbon::create(2025, 9, 30),
            'status' => 'Pending',
            'notes' => 'Ahadi ya miradi maalum ya kanisa',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 3, 1),
            'updated_at' => Carbon::now(),
        ];

        // Member 5: Joshua Mwakyembe (MEM2025005) - Engineer, large pledges
        $pledges[] = [
            'member_id' => $members[4]->id,
            'pledge_type' => 'Ujenzi Kanisa 2025',
            'amount' => 2000000,
            'amount_paid' => 1200000, // Partially paid
            'pledge_date' => Carbon::create(2025, 1, 10),
            'due_date' => Carbon::create(2025, 12, 31),
            'status' => 'Partial',
            'notes' => 'Ahadi ya ujenzi wa kanisa - Mshauri wa miradi',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 1, 10),
            'updated_at' => Carbon::now(),
        ];

        $pledges[] = [
            'member_id' => $members[4]->id,
            'pledge_type' => 'Usiku wa Agape 2025',
            'amount' => 500000,
            'amount_paid' => 500000, // Fully paid
            'pledge_date' => Carbon::create(2025, 1, 20),
            'due_date' => Carbon::create(2025, 11, 30),
            'status' => 'Completed',
            'notes' => 'Ahadi ya usiku wa Agape - Imelipwa kikamilifu',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 1, 20),
            'updated_at' => Carbon::now(),
        ];

        // Member 6: Grace Ndunguru (MEM2025006) - Accountant, moderate pledges
        $pledges[] = [
            'member_id' => $members[5]->id,
            'pledge_type' => 'Mavuno 2025',
            'amount' => 250000,
            'amount_paid' => 100000, // Partially paid
            'pledge_date' => Carbon::create(2025, 2, 5),
            'due_date' => Carbon::create(2025, 6, 30),
            'status' => 'Partial',
            'notes' => 'Ahadi ya sherehe ya mavuno',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 2, 5),
            'updated_at' => Carbon::now(),
        ];

        $pledges[] = [
            'member_id' => $members[5]->id,
            'pledge_type' => 'Kiwanja 2025',
            'amount' => 400000,
            'amount_paid' => 200000, // Partially paid
            'pledge_date' => Carbon::create(2025, 1, 12),
            'due_date' => Carbon::create(2025, 12, 31),
            'status' => 'Partial',
            'notes' => 'Ahadi ya kiwanja 2025',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 1, 12),
            'updated_at' => Carbon::now(),
        ];

        // Member 7: Peter Msuya (MEM2025007) - Student, smaller pledges
        $pledges[] = [
            'member_id' => $members[6]->id,
            'pledge_type' => 'Mavuno 2025',
            'amount' => 50000,
            'amount_paid' => 50000, // Fully paid
            'pledge_date' => Carbon::create(2025, 2, 20),
            'due_date' => Carbon::create(2025, 6, 30),
            'status' => 'Completed',
            'notes' => 'Ahadi ya mavuno - Mwanafunzi, amelipa kikamilifu',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 2, 20),
            'updated_at' => Carbon::now(),
        ];

        // Member 8: Joyce Kilave (MEM2025008) - Doctor, large pledges
        $pledges[] = [
            'member_id' => $members[7]->id,
            'pledge_type' => 'Ujenzi Kanisa 2025',
            'amount' => 1500000,
            'amount_paid' => 750000, // Partially paid
            'pledge_date' => Carbon::create(2025, 1, 18),
            'due_date' => Carbon::create(2025, 12, 31),
            'status' => 'Partial',
            'notes' => 'Ahadi ya ujenzi wa kanisa',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 1, 18),
            'updated_at' => Carbon::now(),
        ];

        $pledges[] = [
            'member_id' => $members[7]->id,
            'pledge_type' => 'Usiku wa Agape 2025',
            'amount' => 600000,
            'amount_paid' => 300000, // Partially paid
            'pledge_date' => Carbon::create(2025, 1, 25),
            'due_date' => Carbon::create(2025, 11, 30),
            'status' => 'Partial',
            'notes' => 'Ahadi ya usiku wa Agape',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 1, 25),
            'updated_at' => Carbon::now(),
        ];

        // Member 9: Michael Lyatuu (MEM2025009) - Journalist, moderate pledges
        $pledges[] = [
            'member_id' => $members[8]->id,
            'pledge_type' => 'Miradi Maalum 2025',
            'amount' => 300000,
            'amount_paid' => 0, // Not yet paid
            'pledge_date' => Carbon::create(2025, 2, 28),
            'due_date' => Carbon::create(2025, 9, 30),
            'status' => 'Pending',
            'notes' => 'Ahadi ya miradi ya media na mawasiliano',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 2, 28),
            'updated_at' => Carbon::now(),
        ];

        $pledges[] = [
            'member_id' => $members[8]->id,
            'pledge_type' => 'Mavuno 2025',
            'amount' => 150000,
            'amount_paid' => 75000, // Partially paid
            'pledge_date' => Carbon::create(2025, 2, 12),
            'due_date' => Carbon::create(2025, 6, 30),
            'status' => 'Partial',
            'notes' => 'Ahadi ya sherehe ya mavuno',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 2, 12),
            'updated_at' => Carbon::now(),
        ];

        // Member 10: Ruth Swai (MEM2025010) - Bank Manager, large pledges
        $pledges[] = [
            'member_id' => $members[9]->id,
            'pledge_type' => 'Kiwanja 2025',
            'amount' => 800000,
            'amount_paid' => 800000, // Fully paid
            'pledge_date' => Carbon::create(2025, 1, 6),
            'due_date' => Carbon::create(2025, 12, 31),
            'status' => 'Completed',
            'notes' => 'Ahadi ya kiwanja - Imelipwa kikamilifu',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 1, 6),
            'updated_at' => Carbon::now(),
        ];

        $pledges[] = [
            'member_id' => $members[9]->id,
            'pledge_type' => 'Ujenzi Kanisa 2025',
            'amount' => 1800000,
            'amount_paid' => 900000, // Partially paid
            'pledge_date' => Carbon::create(2025, 1, 22),
            'due_date' => Carbon::create(2025, 12, 31),
            'status' => 'Partial',
            'notes' => 'Ahadi ya ujenzi wa kanisa - Mshauri wa fedha',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 1, 22),
            'updated_at' => Carbon::now(),
        ];

        $pledges[] = [
            'member_id' => $members[9]->id,
            'pledge_type' => 'Usiku wa Agape 2025',
            'amount' => 400000,
            'amount_paid' => 200000, // Partially paid
            'pledge_date' => Carbon::create(2025, 2, 3),
            'due_date' => Carbon::create(2025, 11, 30),
            'status' => 'Partial',
            'notes' => 'Ahadi ya usiku wa Agape',
            'created_by' => $createdBy,
            'created_at' => Carbon::create(2025, 2, 3),
            'updated_at' => Carbon::now(),
        ];

        // Create all pledges
        foreach ($pledges as $pledge) {
            Pledge::create($pledge);
        }

        $this->command->info('✓ ' . count($pledges) . ' ahadi (pledges) zimeongezwa successfully!');
        $this->command->info('  - Pending: ' . collect($pledges)->where('status', 'Pending')->count());
        $this->command->info('  - Partial: ' . collect($pledges)->where('status', 'Partial')->count());
        $this->command->info('  - Completed: ' . collect($pledges)->where('status', 'Completed')->count());
    }
}
