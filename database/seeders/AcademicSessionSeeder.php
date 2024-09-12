<?php

namespace Database\Seeders;

use App\Models\AcademicSession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminUser = AcademicSession::create([
            'session' => '2023/24',
            'from_date' => '2024-01-01',
            'to_date' => '2024-04-30',
            'is_active' => 1
        ]);
    }
}