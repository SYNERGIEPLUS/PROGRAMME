<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $noms = ['M. Koama', 'M. Sawadogo', 'Mme Chloe', 'M. David', 'M. Kaboré', 'M. Tougouma', 'M. Paspougda', 'M. Traore', 'M. Gbangou', 'M. Diallo'];
        foreach (range(1, 10) as $i) {
            \App\Models\Personnes::create([
                'nom' => $noms[$i - 1],
                'code' => 'X' . $i,
            ]);
        }
    }

}
