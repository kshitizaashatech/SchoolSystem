<?php

namespace Database\Seeders;

use App\Models\FeeType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class FeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $feetypes = [
            [
                'name' => 'Admission Fees',
                'code' => '100',
                'description' => 'Admission Fees'
            ],
            [
                'name' => 'Bus Fees',
                'code' => '101',
                'description' => 'Bus Fees'
            ],
            [
                'name' => 'Certificate fee',
                'code' => '102',
                'description' => 'Certificate fee'
            ],
            [
                'name' => 'Exam Fees',
                'code' => '103',
                'description' => 'Exam Fees'
            ],
            [
                'name' => 'January Month Fees',
                'code' => '104',
                'description' => 'January Month Fees'
            ]
        ];

        $feetypesWithTimestamps = array_map(function ($feetype) {
            return array_merge($feetype, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $feetypes);

        DB::table('fee_types')->insert($feetypesWithTimestamps);
    }
}
