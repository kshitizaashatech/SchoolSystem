<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeederSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminUser = School::create([
            'state_id' => 1,
            'district_id' => 1,
            'municipality_id' => 1,
            'ward_id' => 1,
            'name' => 'school A'
        ]);
    }
}
