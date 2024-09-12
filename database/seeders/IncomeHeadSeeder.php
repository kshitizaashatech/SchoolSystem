<?php

namespace Database\Seeders;

use App\Models\IncomeHead;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class IncomeHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Donations',
                'description' => 'Stationery'
            ],
            [
                'name' => 'Rents',
                'description' => 'Rents'
            ],
            [
                'name' => 'Miscellaneous',
                'description' => 'Miscellaneous'
            ],
            [
                'name' => 'Book Sales',
                'description' => 'Book Sales'
            ],
            [
                'name' => 'Uniform Sales',
                'description' => 'Uniform Sales'
            ],
            [
                'name' => 'Grants',
                'description' => 'Grants'
            ],
            [
                'name' => 'Tution Fees',
                'description' => 'Tution Fees'
            ]
        ];

        $incomeheads = array_map(function ($incomehead) {
            return array_merge($incomehead, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $data);

        DB::table('incomeheads')->insert($incomeheads);
        
    }
}
