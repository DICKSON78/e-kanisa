<?php

namespace Database\Seeders;

use App\Models\Jumuiya;
use Illuminate\Database\Seeder;

class JumuiyaSeeder extends Seeder
{
    public function run(): void
    {
        $jumuiyas = [
            [
                'name' => 'Jumuiya Israel',
                'slug' => 'jumuiya-israel',
                'description' => 'Jumuiya ya Israel',
                'location' => 'Eneo la Kaskazini',
                'is_active' => true,
            ],
            [
                'name' => 'Jumuiya Yuda',
                'slug' => 'jumuiya-yuda',
                'description' => 'Jumuiya ya Yuda',
                'location' => 'Eneo la Kusini',
                'is_active' => true,
            ],
            [
                'name' => 'Jumuiya Kanaani',
                'slug' => 'jumuiya-kanaani',
                'description' => 'Jumuiya ya Kanaani',
                'location' => 'Eneo la Mashariki',
                'is_active' => true,
            ],
            [
                'name' => 'Jumuiya Betheli',
                'slug' => 'jumuiya-betheli',
                'description' => 'Jumuiya ya Betheli',
                'location' => 'Eneo la Magharibi',
                'is_active' => true,
            ],
            [
                'name' => 'Jumuiya Gilgali',
                'slug' => 'jumuiya-gilgali',
                'description' => 'Jumuiya ya Gilgali',
                'location' => 'Eneo la Kati',
                'is_active' => true,
            ],
        ];

        foreach ($jumuiyas as $jumuiya) {
            Jumuiya::firstOrCreate(
                ['slug' => $jumuiya['slug']],
                $jumuiya
            );
        }
    }
}
