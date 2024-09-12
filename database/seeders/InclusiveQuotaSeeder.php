<?php

namespace Database\Seeders;

use App\Models\Inclusivequota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class InclusiveQuotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $incluseivequotas = [
            [
                'name' => 'Women',
                'description' => 'women',
                'priority' => 1
            ],
            [
                'name' => 'Adiwasi/Janajati',
                'description' => 'adiwasi janajati',
                'priority' => 2
            ],
            [
                'name' => 'Madhesi',
                'description' => 'madhesi',
                'priority' => 3
            ],
            [
                'name' => 'Dalit',
                'description' => 'dalit',
                'priority' => 4
            ],
            [
                'name' => 'Tharu',
                'description' => 'tharu',
                'priority' => 5
            ],
            [
                'name' => 'Muslim',
                'description' => 'muslim',
                'priority' => 6
            ],
            [
                'name' => 'Differently Abled People',
                'description' => 'Differently abled People',
                'priority' => 7
            ],
            [
                'name' => 'Backward Area ',
                'description' => 'Backward Area',
                'priority' => 8
            ],
        ];

        $inclusicequotaWithTimestamps = array_map(function ($inclusicequota) {
            return array_merge($inclusicequota, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $incluseivequotas);

        DB::table('inclusivequotas')->insert($inclusicequotaWithTimestamps);
    }
}
