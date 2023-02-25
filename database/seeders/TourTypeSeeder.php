<?php

namespace Database\Seeders;

use App\Models\TourType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TourTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TourType::create([
            'name'=> 'Perezosos'
        ]);

        TourType::create([
            'name'=> 'Aves'
        ]);

        TourType::create([
            'name'=> 'Nocturno'
        ])

        ;TourType::create([
            'name'=> 'Ranas'
        ]);
    }
}
