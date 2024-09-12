<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'type' => 'Medical Leave'
            ],
            [
                'name' => 'Casual Leave'
            ],
            [
                'name' => 'Maternity Leave'
            ]
        ];

        $leavetypes = array_map(function ($leavetype) {
            return array_merge($leavetype, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $data);

        DB::table('leave_types')->insert($leavetypes);
    }
}
