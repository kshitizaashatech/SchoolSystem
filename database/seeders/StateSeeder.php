<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
                [
                    'id' => 1,
                    'name' => 'Koshi Province',
                    'name_np' => 'कोशी प्रदेश'
                ],
                [
                    'id' => 2,
                    'name' => 'Madhesh Province',
                    'name_np' => 'मधेश प्रदेश'
                ],
                [
                    'id' => 3,
                    'name' => 'Bagmati Province',
                    'name_np' => 'बाग्मती प्रदेश'
                ],
                [
                    'id' => 4,
                    'name' => 'Gandaki Province',
                    'name_np' => 'गण्डकी प्रदेश'
                ],
                [
                    'id' => 5,
                    'name' => 'Lumbini Province',
                    'name_np' => 'लुम्बिनी प्रदेश'
                ],
                [
                    'id' => 6,
                    'name' => 'Karnali Province',
                    'name_np' => 'कर्णाली प्रदेश'
                ],
                [
                    'id' => 7,
                    'name' => 'Sudurpaschim Province',
                    'name_np' => 'सुदुरपश्चिम प्रदेश'
                ]
          
        ];

        DB::table('states')->insert($data);
    }
}
