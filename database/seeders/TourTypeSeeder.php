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
            'name'=> 'Perezosos Dolares',
            'money' => 2,
            'fee1' => 8 ,
            'fee2' => 12 ,
            'fee3' => 17 ,
            'fee4' => 23 ,
        ]);

        TourType::create([
            'name'=> 'Aves Dolares',
            'money' => 2 ,
            'fee1' => 25 ,
            'fee2' => 35 ,
            'fee3' => 45 ,
            'fee4' => 55 ,

        ]);

        TourType::create([
            'name'=> 'Nocturno Dolares',
            'money' => 2,
            'fee1' => 25 ,
            'fee2' => 35 ,
            'fee3' => 45 ,
            'fee4' => 55 ,
        ])

        ;TourType::create([
            'name'=> 'Ranas Dolares',
            'money' => 2,
            'fee1' => 25 ,
            'fee2' => 35 ,
            'fee3' => 45 ,
            'fee4' => 55 ,
        ]);
    }
}
