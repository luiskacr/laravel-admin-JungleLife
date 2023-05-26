<?php

namespace Database\Seeders;

use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tour=6;

        for ($x = 0; $x <= $tour ; $x++){
            Tour::create([
                'title' => 'Test',
                'start' => Carbon::now('America/Costa_Rica')->set(['hour'=> 9,'second'=>0])->add($x,'day')->format('Y-m-d H:i:s'),
                'end' => Carbon::now('America/Costa_Rica')->set(['hour'=> 10,'second'=>0])->add($x,'day')->format('Y-m-d H:i:s'),
                'info' => 'Auto',
                'state' =>1,
                'type' =>1,
                'user' =>1 ,
            ]);
        }

    }
}
