<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $designations = [
            'Faculty',
            'Accountant',
            'Admin',
            'Receptionist',
            'Principal',
            'Director',
            'Librarian',
            'Technical Head',
            'Helper'
        ];


        foreach ($designations as $designation) {
            Designation::create([
                'name' => $designation
            ]);
        }
    }
}
