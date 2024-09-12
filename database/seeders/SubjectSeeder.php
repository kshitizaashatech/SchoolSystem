<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'school_id' => '1',
                'subject_code' => 'math',
                'subject' => 'Mathematices',
                'credit_hour' => '101',
            ],
            [
                'school_id' => '1',
                'subject_code' => 'eng',
                'subject' => 'English',
                'credit_hour' => '102',
            ],
            [
                'school_id' => '1',
                'subject_code' => 'nep',
                'subject' => 'Nepali',
                'credit_hour' => '103',
            ],
            [
                'school_id' => '1',
                'subject_code' => 'sci',
                'subject' => 'Science',
                'credit_hour' => '104',
            ],
            [
                'school_id' => '1',
                'subject_code' => 'ss',
                'subject' => 'Social Studies',
                'credit_hour' => '105',
            ],
            [
                'school_id' => '1',
                'subject_code' => 'com',
                'subject' => 'Computer Science',
                'credit_hour' => '106',
            ]
        ];

        $subjects = array_map(function ($incomehead) {
            return array_merge($incomehead, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $data);

        DB::table('subjects')->insert($subjects);
    }
}
