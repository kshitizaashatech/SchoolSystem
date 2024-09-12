<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarksGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'grade_name' => 'A+',
                'grade_points_from' => 3.61,
                'grade_points_to' => 4.0,
                'percentage_from' => 90,
                'percentage_to' => 100,
                'achievement_description' => 'Outstanding',
                'is_active' => 1,
            ],
            [
                'id' => 2,
                'grade_name' => "A",
                'grade_points_from' => 3.21,
                'grade_points_to' => 3.6,
                'percentage_from' => 80,
                'percentage_to' => 90,
                'achievement_description' => 'Excellent',
                'is_active' => 1,
            ],
            [
                'id' => 3,
                'grade_name' => "B+",
                'grade_points_from' => 2.81,
                'grade_points_to' => 3.2,
                'percentage_from' => 70,
                'percentage_to' => 80,
                'achievement_description' => 'Very Good',
                'is_active' => 1,
            ],
            [
                'id' => 4,
                'grade_name' => "B",
                'grade_points_from' => 2.41,
                'grade_points_to' => 2.8,
                'percentage_from' => 60,
                'percentage_to' => 70,
                'achievement_description' => 'Good',
                'is_active' => 1,
            ],
            [
                'id' => 5,
                'grade_name' => "C+",
                'grade_points_from' => 2.01,
                'grade_points_to' => 2.4,
                'percentage_from' => 50,
                'percentage_to' => 60,
                'achievement_description' => 'Satisfactory',
                'is_active' => 1,
            ],
            [
                'id' => 6,
                'grade_name' => "C",
                'grade_points_from' => 1.61,
                'grade_points_to' => 2.0,
                'percentage_from' => 40,
                'percentage_to' => 50,
                'achievement_description' => 'Acceptable',
                'is_active' => 1,
            ],
            [
                'id' => 7,
                'grade_name' => "D",
                'grade_points_from' => 1.6,
                'grade_points_to' => 1.6,
                'percentage_from' => 35,
                'percentage_to' => 40,
                'achievement_description' => 'Basic',
                'is_active' => 1,
            ],
            [
                'id' => 8,
                'grade_name' => "NG",
                'grade_points_from' => 0,
                'grade_points_to' => 1.6,
                'percentage_from' => 0,
                'percentage_to' => 35,
                'achievement_description' => 'Not Graded',
                'is_active' => 1,
            ],


        ];
        $grades = array_map(function ($incomehead) {
            return array_merge($incomehead, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $data);

        DB::table('marks_grades')->insert($grades);
    }
}
