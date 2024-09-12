<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            'super_admin',
            'district',
            'municipality',
            'head_school',
            'school_admin',
            'staffs',
            'parents',
            'students'
        ];


        foreach ($userTypes as $user) {
            UserType::create([
                'title' => $user
            ]);
        }
    }
}
