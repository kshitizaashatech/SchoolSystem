<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
                [
                    'id' => 1,
                    'province_id' => 1,
                    'name' => 'Bhojpur',
                    'name_np' => 'भोजपुर',
                ],
                [
                    'id' => 2,
                    'province_id' => 1,
                    'name' => 'Dhankuta',
                    'name_np' => 'धनकुटा',
                ],
                [
                    'id' => 3,
                    'province_id' => 1,
                    'name' => 'Ilam',
                    'name_np' => 'इलाम',
                ],
                [
                    'id' => 4,
                    'province_id' => 1,
                    'name' => 'Jhapa',
                    'name_np' => 'झापा',
                ],
                [
                    'id' => 5,
                    'province_id' => 1,
                    'name' => 'Khotang',
                    'name_np' => 'खोटाँग',
                ],
                [
                    'id' => 6,
                    'province_id' => 1,
                    'name' => 'Morang',
                    'name_np' => 'मोरंग',
                ],
                [
                    'id' => 7,
                    'province_id' => 1,
                    'name' => 'Okhaldhunga',
                    'name_np' => 'ओखलढुंगा',
                ],
                [
                    'id' => 8,
                    'province_id' => 1,
                    'name' => 'Pachthar',
                    'name_np' => 'पांचथर',
                ],
                [
                    'id' => 9,
                    'province_id' => 1,
                    'name' => 'Sankhuwasabha',
                    'name_np' => 'संखुवासभा',
                ],
                [
                    'id' => 10,
                    'province_id' => 1,
                    'name' => 'Solukhumbu',
                    'name_np' => 'सोलुखुम्बू',
                ],
                [
                    'id' => 11,
                    'province_id' => 1,
                    'name' => 'Sunsari',
                    'name_np' => 'सुनसरी',
                ],
                [
                    'id' => 12,
                    'province_id' => 1,
                    'name' => 'Taplejung',
                    'name_np' => 'ताप्लेजुंग',
                ],
                [
                    'id' => 13,
                    'province_id' => 1,
                    'name' => 'Terhathum',
                    'name_np' => 'तेह्रथुम',
                ],
                [
                    'id' => 14,
                    'province_id' => 1,
                    'name' => 'Udayapur',
                    'name_np' => 'उदयपुर',
                ],
                [
                    'id' => 15,
                    'province_id' => 2,
                    'name' => 'Parsa',
                    'name_np' => 'पर्सा',
                ],
                [
                    'id' => 16,
                    'province_id' => 2,
                    'name' => 'Bara',
                    'name_np' => 'बारा',
                ],
                [
                    'id' => 17,
                    'province_id' => 2,
                    'name' => 'Rautahat',
                    'name_np' => 'रौतहट',
                ],
                [
                    'id' => 18,
                    'province_id' => 2,
                    'name' => 'Sarlahi',
                    'name_np' => 'सर्लाही',
                ],
                [
                    'id' => 19,
                    'province_id' => 2,
                    'name' => 'Siraha',
                    'name_np' => 'सिराहा',
                ],
                [
                    'id' => 20,
                    'province_id' => 2,
                    'name' => 'Dhanusha',
                    'name_np' => 'धनुषा',
                ],
                [
                    'id' => 21,
                    'province_id' => 2,
                    'name' => 'Saptari',
                    'name_np' => 'सप्तरी',
                ],
                [
                    'id' => 22,
                    'province_id' => 2,
                    'name' => 'Mahottari',
                    'name_np' => 'महोत्तरी',
                ],
                [
                    'id' => 23,
                    'province_id' => 3,
                    'name' => 'Bhaktapur',
                    'name_np' => 'भक्तपुर',
                ],
                [
                    'id' => 24,
                    'province_id' => 3,
                    'name' => 'Chitwan',
                    'name_np' => 'चितवन',
                ],
                [
                    'id' => 25,
                    'province_id' => 3,
                    'name' => 'Dhading',
                    'name_np' => 'धादिंङ्ग',
                ],
                [
                    'id' => 26,
                    'province_id' => 3,
                    'name' => 'Dolakha',
                    'name_np' => 'दोलखा',
                ],
                [
                    'id' => 27,
                    'province_id' => 3,
                    'name' => 'Kathmandu',
                    'name_np' => 'काठमाडौँ',
                ],
                [
                    'id' => 28,
                    'province_id' => 3,
                    'name' => 'Kavrepalanchok',
                    'name_np' => 'काभ्रेपलान्चोक'
                ],
                [
                    'id' => 29,
                    'province_id' => 3,
                    'name' => 'Lalitpur',
                    'name_np' => 'ललितपुर',
                ],
                [
                    'id' => 30,
                    'province_id' => 3,
                    'name' => 'Makwanpur',
                    'name_np' => 'मकवानपुर',
                ],
                [
                    'id' => 31,
                    'province_id' => 3,
                    'name' => 'Nuwakot',
                    'name_np' => 'नुवाकोट',
                ],
                [
                    'id' => 32,
                    'province_id' => 3,
                    'name' => 'Ramechap',
                    'name_np' => 'रामेछाप',
                ],
                [
                    'id' => 33,
                    'province_id' => 3,
                    'name' => 'Rasuwa',
                    'name_np' => 'रसुवा',
                ],
                [
                    'id' => 34,
                    'province_id' => 3,
                    'name' => 'Sindhuli',
                    'name_np' => 'सिन्धुली',
                ],
                [
                    'id' => 35,
                    'province_id' => 3,
                    'name' => 'Sindhupalchok',
                    'name_np' => 'सिन्धुपाल्चोक'
                ],
                [
                    'id' => 36,
                    'province_id' => 4,
                    'name' => 'Baglung',
                    'name_np' => 'बागलुङ',
                ],
                [
                    'id' => 37,
                    'province_id' => 4,
                    'name' => 'Gorkha',
                    'name_np' => 'गोरखा',
                ],
                [
                    'id' => 38,
                    'province_id' => 4,
                    'name' => 'Kaski',
                    'name_np' => 'कास्की',
                ],
                [
                    'id' => 39,
                    'province_id' => 4,
                    'name' => 'Lamjung',
                    'name_np' => 'लमजुङ',
                ],
                [
                    'id' => 40,
                    'province_id' => 4,
                    'name' => 'Manang',
                    'name_np' => 'मनाङ',
                ],
                [
                    'id' => 41,
                    'province_id' => 4,
                    'name' => 'Mustang',
                    'name_np' => 'मुस्ताङ',
                ],
                [
                    'id' => 42,
                    'province_id' => 4,
                    'name' => 'Myagdi',
                    'name_np' => 'म्याग्दी',
                ],
                [
                    'id' => 43,
                    'province_id' => 4,
                    'name' => 'Nawalpur',
                    'name_np' => 'नवलपुर',
                ],
                [
                    'id' => 44,
                    'province_id' => 4,
                    'name' => 'Parwat',
                    'name_np' => 'पर्वत',
                ],
                [
                    'id' => 45,
                    'province_id' => 4,
                    'name' => 'Syangja',
                    'name_np' => 'स्याङग्जा',
                ],
                [
                    'id' => 46,
                    'province_id' => 4,
                    'name' => 'Tanahun',
                    'name_np' => 'तनहुँ',
                ],
                [
                    'id' => 47,
                    'province_id' => 5,
                    'name' => 'Kapilvastu',
                    'name_np' => 'कपिलवस्तु',
                ],
                [
                    'id' => 48,
                    'province_id' => 5,
                    'name' => 'Parasi',
                    'name_np' => 'परासी',
                ],
                [
                    'id' => 49,
                    'province_id' => 5,
                    'name' => 'Rupandehi',
                    'name_np' => 'रुपन्देही',
                ],
                [
                    'id' => 50,
                    'province_id' => 5,
                    'name' => 'Arghakhanchi',
                    'name_np' => 'अर्घाखाँची',
                ],
                [
                    'id' => 51,
                    'province_id' => 5,
                    'name' => 'Gulmi',
                    'name_np' => 'गुल्मी',
                ],
                [
                    'id' => 52,
                    'province_id' => 5,
                    'name' => 'Palpa',
                    'name_np' => 'पाल्पा',
                ],
                [
                    'id' => 53,
                    'province_id' => 5,
                    'name' => 'Dang',
                    'name_np' => 'दाङ',
                ],
                [
                    'id' => 54,
                    'province_id' => 5,
                    'name' => 'Pyuthan',
                    'name_np' => 'प्युठान',
                ],
                [
                    'id' => 55,
                    'province_id' => 5,
                    'name' => 'Rolpa',
                    'name_np' => 'रोल्पा',
                ],
                [
                    'id' => 56,
                    'province_id' => 5,
                    'name' => 'Eastern Rukum',
                    'name_np' => 'पूर्वी रूकुम'
                ],
                [
                    'id' => 57,
                    'province_id' => 5,
                    'name' => 'Banke',
                    'name_np' => 'बाँके',
                ],
                [
                    'id' => 58,
                    'province_id' => 5,
                    'name' => 'Bardiya',
                    'name_np' => 'बर्दिया',
                ],
                [
                    'id' => 59,
                    'province_id' => 6,
                    'name' => 'Western Rukum',
                    'name_np' => 'रुकुम पश्चिम'
                ],
                [
                    'id' => 60,
                    'province_id' => 6,
                    'name' => 'Salyan',
                    'name_np' => 'सल्यान',
                ],
                [
                    'id' => 61,
                    'province_id' => 6,
                    'name' => 'Dolpa',
                    'name_np' => 'डोल्पा',
                ],
                [
                    'id' => 62,
                    'province_id' => 6,
                    'name' => 'Humla',
                    'name_np' => 'हुम्ला',
                ],
                [
                    'id' => 63,
                    'province_id' => 6,
                    'name' => 'Jumla',
                    'name_np' => 'जुम्ला',
                ],
                [
                    'id' => 64,
                    'province_id' => 6,
                    'name' => 'Kalikot',
                    'name_np' => 'कालिकोट',
                ],
                [
                    'id' => 65,
                    'province_id' => 6,
                    'name' => 'Mugu',
                    'name_np' => 'मुगु',
                ],
                [
                    'id' => 66,
                    'province_id' => 6,
                    'name' => 'Surkhet',
                    'name_np' => 'सुर्खेत',
                ],
                [
                    'id' => 67,
                    'province_id' => 6,
                    'name' => 'Dailekh',
                    'name_np' => 'दैलेख',
                ],
                [
                    'id' => 68,
                    'province_id' => 6,
                    'name' => 'Jajarkot',
                    'name_np' => 'जाजरकोट',
                ],
                [
                    'id' => 69,
                    'province_id' => 7,
                    'name' => 'Darchula',
                    'name_np' => 'दार्चुला',
                ],
                [
                    'id' => 70,
                    'province_id' => 7,
                    'name' => 'Bajhang',
                    'name_np' => 'बझाङ',
                ],
                [
                    'id' => 71,
                    'province_id' => 7,
                    'name' => 'Bajura',
                    'name_np' => 'बाजुरा',
                ],
                [
                    'id' => 72,
                    'province_id' => 7,
                    'name' => 'Baitadi',
                    'name_np' => 'बैतडी',
                ],
                [
                    'id' => 73,
                    'province_id' => 7,
                    'name' => 'Doti',
                    'name_np' => 'डोटी',
                ],
                [
                    'id' => 74,
                    'province_id' => 7,
                    'name' => 'Acham',
                    'name_np' => 'अछाम',
                ],
                [
                    'id' => 75,
                    'province_id' => 7,
                    'name' => 'Dadeldhura',
                    'name_np' => 'डडेलधुरा',
                ],
                [
                    'id' => 76,
                    'province_id' => 7,
                    'name' => 'Kanchanpur',
                    'name_np' => 'कञ्चनपुर',
                ],
                [
                    'id' => 77,
                    'province_id' => 7,
                    'name' => 'Kailali',
                    'name_np' => 'कैलाली',
                ]
      
        ];

        DB::table('districts')->insert($data);
    }
}
