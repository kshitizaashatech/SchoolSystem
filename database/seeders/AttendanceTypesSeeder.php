<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AttendanceTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'type' => 'Present',
            ],
            [
                'type' => 'Absent',
            ],
            [
                'type' => 'Late',
            ],
            [
                'type' => 'Holiday',
            ],
            [
                'type' => 'Half Day',
            ],
            [
                'type' => 'Late with Excuse',
            ]
        ];

        $attendencetypes = array_map(function ($attendencetype) {
            return array_merge($attendencetype, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $data);

        DB::table('attendance_types')->insert($attendencetypes);

    }
}
