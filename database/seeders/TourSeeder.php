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
        Tour::create([
            'title' => 'Test',
            'start' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-01-09 12:00:00'),
            'end' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-01-09 13:00:00'),
            'info' => 'Auto',
            'state' =>1,
            'type' =>1,
            'user' =>1 ,
        ]);

        Tour::create([
            'title' => 'Test',
            'start' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-01-09 14:00:00'),
            'end' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-01-09 15:00:00'),
            'info' => 'Auto',
            'state' =>1,
            'type' =>1,
            'user' =>1 ,
        ]);

        Tour::create([
            'title' => 'Test',
            'start' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-01-10 09:00:00'),
            'end' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-01-10 10:00:00'),
            'info' => 'Auto',
            'state' =>1,
            'type' =>1,
            'user' =>1 ,
        ]);
    }
}
