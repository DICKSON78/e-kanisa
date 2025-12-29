<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Income;
use Carbon\Carbon;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Generate income data for the last 6 months
        $incomes = [];

        for ($monthsAgo = 5; $monthsAgo >= 0; $monthsAgo--) {
            $date = Carbon::now()->subMonths($monthsAgo);
            $year = $date->year;
            $month = $date->month;

            // Week 1 - First Sunday
            $week1Date = Carbon::create($year, $month, 7)->startOfWeek()->addDays(6);

            // Sadaka ya Jumapili - Week 1
            $incomes[] = [
                'income_category_id' => 2, // SHUKRANI YA WIKI
                'collection_date' => $week1Date->format('Y-m-d'),
                'amount' => rand(250000, 400000),
                'notes' => 'Sadaka ya Jumapili - Wiki ya 1',
                'receipt_number' => 'RCP' . $week1Date->format('Ymd') . '001',
                'created_by' => 1,
                'created_at' => $week1Date,
                'updated_at' => $week1Date,
            ];

            // Week 2 - Second Sunday
            $week2Date = Carbon::create($year, $month, 14)->startOfWeek()->addDays(6);

            $incomes[] = [
                'income_category_id' => 2, // SHUKRANI YA WIKI
                'collection_date' => $week2Date->format('Y-m-d'),
                'amount' => rand(280000, 420000),
                'notes' => 'Sadaka ya Jumapili - Wiki ya 2',
                'receipt_number' => 'RCP' . $week2Date->format('Ymd') . '002',
                'created_by' => 1,
                'created_at' => $week2Date,
                'updated_at' => $week2Date,
            ];

            // Week 3 - Third Sunday
            $week3Date = Carbon::create($year, $month, 21)->startOfWeek()->addDays(6);

            $incomes[] = [
                'income_category_id' => 2, // SHUKRANI YA WIKI
                'collection_date' => $week3Date->format('Y-m-d'),
                'amount' => rand(270000, 410000),
                'notes' => 'Sadaka ya Jumapili - Wiki ya 3',
                'receipt_number' => 'RCP' . $week3Date->format('Ymd') . '003',
                'created_by' => 1,
                'created_at' => $week3Date,
                'updated_at' => $week3Date,
            ];

            // Week 4 - Fourth Sunday
            $week4Date = Carbon::create($year, $month, 28)->startOfWeek()->addDays(6);
            if ($week4Date->month == $month) {
                $incomes[] = [
                    'income_category_id' => 2, // SHUKRANI YA WIKI
                    'collection_date' => $week4Date->format('Y-m-d'),
                    'amount' => rand(260000, 400000),
                    'notes' => 'Sadaka ya Jumapili - Wiki ya 4',
                    'receipt_number' => 'RCP' . $week4Date->format('Ymd') . '004',
                    'created_by' => 1,
                    'created_at' => $week4Date,
                    'updated_at' => $week4Date,
                ];
            }

            // Sadaka ya Ahadi - Monthly
            $ahadiDate = Carbon::create($year, $month, 15);
            $incomes[] = [
                'income_category_id' => 3, // SADAKA YA AHADI
                'collection_date' => $ahadiDate->format('Y-m-d'),
                'amount' => rand(500000, 800000),
                'notes' => 'Sadaka ya Ahadi - ' . $ahadiDate->translatedFormat('F Y'),
                'receipt_number' => 'RCP' . $ahadiDate->format('Ymd') . '010',
                'created_by' => 1,
                'created_at' => $ahadiDate,
                'updated_at' => $ahadiDate,
            ];

            // Shule ya Jumapili - Monthly average
            $shuleDate = Carbon::create($year, $month, 20);
            $incomes[] = [
                'income_category_id' => 4, // SHULE YA JUMAPILI
                'collection_date' => $shuleDate->format('Y-m-d'),
                'amount' => rand(80000, 150000),
                'notes' => 'Michango ya Shule ya Jumapili',
                'receipt_number' => 'RCP' . $shuleDate->format('Ymd') . '015',
                'created_by' => 1,
                'created_at' => $shuleDate,
                'updated_at' => $shuleDate,
            ];

            // Fungu la Kumi (Zaka) - Monthly
            $zakaDate = Carbon::create($year, $month, 10);
            $incomes[] = [
                'income_category_id' => 11, // SADAKA FUNGU LA KUMI
                'collection_date' => $zakaDate->format('Y-m-d'),
                'amount' => rand(300000, 600000),
                'notes' => 'Fungu la Kumi (Zaka)',
                'receipt_number' => 'RCP' . $zakaDate->format('Ymd') . '020',
                'created_by' => 1,
                'created_at' => $zakaDate,
                'updated_at' => $zakaDate,
            ];

            // Sadaka ya Jengo - Monthly
            $jengoDate = Carbon::create($year, $month, 25);
            $incomes[] = [
                'income_category_id' => 13, // SADAKA YA JENGO
                'collection_date' => $jengoDate->format('Y-m-d'),
                'amount' => rand(400000, 900000),
                'notes' => 'Mchango wa Ujenzi wa Kanisa',
                'receipt_number' => 'RCP' . $jengoDate->format('Ymd') . '025',
                'created_by' => 1,
                'created_at' => $jengoDate,
                'updated_at' => $jengoDate,
            ];

            // Michango Mbalimbali
            if (rand(1, 3) == 1) {
                $michangoDate = Carbon::create($year, $month, rand(5, 28));
                $incomes[] = [
                    'income_category_id' => 14, // MICHANGO MBALIMBALI
                    'collection_date' => $michangoDate->format('Y-m-d'),
                    'amount' => rand(100000, 300000),
                    'notes' => 'Michango mbalimbali kutoka kwa waumini',
                    'receipt_number' => 'RCP' . $michangoDate->format('Ymd') . '030',
                    'created_by' => 1,
                    'created_at' => $michangoDate,
                    'updated_at' => $michangoDate,
                ];
            }
        }

        // Special offerings for specific months
        // January - New Year
        if ($currentMonth >= 1 || $currentMonth <= 12) {
            $newYearDate = Carbon::create($currentYear, 1, 1);
            if ($newYearDate->isPast() && $newYearDate->diffInMonths(Carbon::now()) <= 6) {
                $incomes[] = [
                    'income_category_id' => 1, // SADAKA YA MWAKA MPYA
                    'collection_date' => $newYearDate->format('Y-m-d'),
                    'amount' => rand(600000, 1000000),
                    'notes' => 'Sadaka Maalum ya Mwaka Mpya',
                    'receipt_number' => 'RCP' . $newYearDate->format('Ymd') . '100',
                    'created_by' => 1,
                    'created_at' => $newYearDate,
                    'updated_at' => $newYearDate,
                ];
            }
        }

        // Easter offerings (April)
        $easterDate = Carbon::create($currentYear, 4, 15);
        if ($easterDate->isPast() && $easterDate->diffInMonths(Carbon::now()) <= 6) {
            $incomes[] = [
                'income_category_id' => 6, // SADAKA YA PASAKA
                'collection_date' => $easterDate->format('Y-m-d'),
                'amount' => rand(800000, 1200000),
                'notes' => 'Sadaka ya Pasaka na Kufufuka',
                'receipt_number' => 'RCP' . $easterDate->format('Ymd') . '200',
                'created_by' => 1,
                'created_at' => $easterDate,
                'updated_at' => $easterDate,
            ];
        }

        // Harvest offering (Usually June/July)
        $harvestDate = Carbon::create($currentYear, 7, 15);
        if ($harvestDate->isPast() && $harvestDate->diffInMonths(Carbon::now()) <= 6) {
            $incomes[] = [
                'income_category_id' => 5, // SADAKA YA MAVUNO
                'collection_date' => $harvestDate->format('Y-m-d'),
                'amount' => rand(1000000, 1500000),
                'notes' => 'Sadaka ya Mavuno - Sherehe Kuu',
                'receipt_number' => 'RCP' . $harvestDate->format('Ymd') . '300',
                'created_by' => 1,
                'created_at' => $harvestDate,
                'updated_at' => $harvestDate,
            ];
        }

        // Christmas offerings (December)
        $christmasDate = Carbon::create($currentYear - 1, 12, 25);
        if ($christmasDate->diffInMonths(Carbon::now()) <= 6) {
            $incomes[] = [
                'income_category_id' => 21, // SADAKA YA KRISMAS
                'collection_date' => $christmasDate->format('Y-m-d'),
                'amount' => rand(900000, 1400000),
                'notes' => 'Sadaka ya Krismas - Sherehe ya Kuzaliwa Yesu',
                'receipt_number' => 'RCP' . $christmasDate->format('Ymd') . '400',
                'created_by' => 1,
                'created_at' => $christmasDate,
                'updated_at' => $christmasDate,
            ];
        }

        // Thanksgiving offerings
        for ($i = 0; $i < 3; $i++) {
            $thanksgivingDate = Carbon::now()->subMonths(rand(0, 5))->setDay(rand(5, 25));
            $incomes[] = [
                'income_category_id' => 7, // SADAKA YA SHUKRANI AINA ZOTE
                'collection_date' => $thanksgivingDate->format('Y-m-d'),
                'amount' => rand(150000, 400000),
                'notes' => 'Sadaka ya Shukrani - ' . ['Kazi Mpya', 'Mtoto Mpya', 'Ushindi Maalum'][rand(0, 2)],
                'receipt_number' => 'RCP' . $thanksgivingDate->format('Ymd') . (500 + $i),
                'created_by' => 1,
                'created_at' => $thanksgivingDate,
                'updated_at' => $thanksgivingDate,
            ];
        }

        // Baptism offerings
        for ($i = 0; $i < 2; $i++) {
            $baptismDate = Carbon::now()->subMonths(rand(0, 5))->setDay(rand(5, 25));
            $incomes[] = [
                'income_category_id' => 8, // SADAKA YA UBATIZO
                'collection_date' => $baptismDate->format('Y-m-d'),
                'amount' => rand(80000, 200000),
                'notes' => 'Sadaka ya Ubatizo',
                'receipt_number' => 'RCP' . $baptismDate->format('Ymd') . (600 + $i),
                'created_by' => 1,
                'created_at' => $baptismDate,
                'updated_at' => $baptismDate,
            ];
        }

        // Insert all incomes
        foreach ($incomes as $income) {
            Income::create($income);
        }

        $this->command->info('✓ ' . count($incomes) . ' rekodi za mapato zimeongezwa successfully!');
    }
}
