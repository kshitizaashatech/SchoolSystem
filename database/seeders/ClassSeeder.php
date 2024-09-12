<?php

namespace Database\Seeders;

use App\Models\Classg;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            'Class 1',
            'Class 2',
            'Class 3',
            'Class 4'
        ];


        foreach ($classes as $class) {
            Classg::create([
                'class' => $class,
                'school_id' => 1
            ]);
        }
    }
}
