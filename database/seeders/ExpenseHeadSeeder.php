<?php

namespace Database\Seeders;

use App\Models\Expensehead;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ExpenseHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Stationery Purchase',
                'description' => 'Stationery Purchase'
            ],
            [
                'name' => 'Electricity Bill',
                'description' => 'Electricity Bill'
            ],
            [
                'name' => 'Telephone Bill',
                'description' => 'Telephone Bill'
            ],
            [
                'name' => 'Internet Bill',
                'description' => 'Internet Bill'
            ]
        ];

        $expenseheads = array_map(function ($expense) {
            return array_merge($expense, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $data);
        DB::table('expenseheads')->insert($expenseheads);
    }
}
