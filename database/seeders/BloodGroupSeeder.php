<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BloodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bloodGroupTypes = [
            ['type' => 'A+'],
            ['type' => 'A-'],
            ['type' => 'B+'],
            ['type' => 'B-'],
            ['type' => 'AB+'],
            ['type' => 'AB-'],
            ['type' => 'O+'],
            ['type' => 'O-'],
        ];
        $bloodgroups = array_map(function ($groups) {
            return array_merge($groups, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $bloodGroupTypes);

        DB::table('bloodgroup_types')->insert($bloodgroups);
    }
}
