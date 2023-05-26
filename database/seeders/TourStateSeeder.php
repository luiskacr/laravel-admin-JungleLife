<?php

namespace Database\Seeders;

use App\Models\TourState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TourStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TourState::create([
            'name'=> 'Abierto'
        ]);

        TourState::create([
            'name'=> 'Cerrado'
        ]);
    }
}
