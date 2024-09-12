<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            'A(en)',
            'A(np)',
            'B(en)',
            'B(np)',
            'C(en)',
            'C(np)'
        ];


        foreach ($sections as $section) {
            Section::create([
                'section_name' => $section,
            ]);
        }
    }
}
