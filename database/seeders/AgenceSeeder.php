<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agences = [
            'Agence de Abomey',
            'Agence de Adjohoun',
            'Agence de Agbangnizoun',
            'Agence de Aklampa',
            'Agence de Akassato',
            'Agence de Allada',
            'Agence de Azovè',
            'Agence de Bantè',
            'Agence de Banikoara',
            'Agence de Bassila',
            'Agence de Bembèrèkè',
            'Agence de Bohicon',
            'Agence de Cobly',
            'Agence de Cococodji',
            'Agence de Comè',
            'Agence de Copargo',
            'Agence de Covè',
            'Agence de Dassa',
            'Agence de Djèrègbé',
            'Agence de Djidja',
            'Agence de Djougou',
            'Agence de Dogbo',
            'Agence de Fidjrossè',
            'Agence de Founougo',
            'Agence de Glazoué',
            'Agence de Godomey',
            'Agence de Gogounou',
            'Agence de Goumori',
            'Agence de Hêvié',
            'Agence de Hlassamè',
            'Agence de Houéyogbé',
            'Agence de Kalalé',
            'Agence de Kandi',
            'Agence de Kérou',
            'Agence de Kétou',
            'Agence de Kilibo',
            'Agence de Klouékanmè',
            'Agence de Kouandé',
            'Agence de Lokossa',
            'Agence de Malanville',
            'Agence de Matéri',
            'Agence de Mènontin',
            'Agence de N\'dali',
            'Agence de Natitingou',
            'Agence de Nikki',
            'Agence de Ouidah',
            'Agence de Ouèssè',
            'Agence de Parakou Albarika',
            'Agence de Parakou Gah',
            'Agence de Parakou Guèma',
            'Agence de Pehunco',
            'Agence de Pèrèrè',
            'Agence de Pobè',
            'Agence de Porto-Novo',
            'Agence de Porto-Novo 2',
            'Agence de Savalou',
            'Agence de Savè',
            'Agence de Ségbana',
            'Agence de Sinendé',
            'Agence de Sainte-Rita',
            'Agence de Sakété',
            'Agence de Tankpè',
            'Agence de Tanguiéta',
            'Agence de Tchaourou',
            'Agence de Tchetti',
            'Agence de Tori Bossito',
            'Agence de Yénawa',
            'Agence de Za-Kpota',
            'Agence de Zè',
            'Agence de Zogbodomey'
        ];

        foreach ($agences as $agence) {
            \DB::table('agences')->insert([
                'nom_agence' => $agence,
                
            ]);
        }
    }
}
