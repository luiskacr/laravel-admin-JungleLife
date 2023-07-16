<?php

namespace Database\Seeders;

use App\Models\Timetables;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
            DB::beginTransaction();

            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',"08:00:00"),
                'end'=> Carbon::createFromFormat('H:i:s',"09:00:00"),
                'auto'=> true,
                'type' => 1
            ]);

            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',"09:00:00"),
                'end'=> Carbon::createFromFormat('H:i:s',"10:00:00"),
                'auto'=> true,
                'type' => 1
            ]);

            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',"10:00:00"),
                'end'=> Carbon::createFromFormat('H:i:s',"11:00:00"),
                'auto'=> true,
                'type' => 1
            ]);

            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',"11:00:00"),
                'end'=> Carbon::createFromFormat('H:i:s',"12:00:00"),
                'auto'=> true,
                'type' => 1
            ]);

            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',"12:00:00"),
                'end'=> Carbon::createFromFormat('H:i:s',"13:00:00"),
                'auto'=> true,
                'type' => 1
            ]);

            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',"13:00:00"),
                'end'=> Carbon::createFromFormat('H:i:s',"14:00:00"),
                'auto'=> true,
                'type' => 1
            ]);

            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',"14:00:00"),
                'end'=> Carbon::createFromFormat('H:i:s',"15:00:00"),
                'auto'=> true,
                'type' => 1
            ]);

            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',"15:00:00"),
                'end'=> Carbon::createFromFormat('H:i:s',"16:00:00"),
                'auto'=> true,
                'type' => 1
            ]);

            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',"16:00:00"),
                'end'=> Carbon::createFromFormat('H:i:s',"17:00:00"),
                'auto'=> true,
                'type' => 1
            ]);

            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',"08:00:00"),
                'end'=> Carbon::createFromFormat('H:i:s',"09:00:00"),
                'auto'=> true,
                'type' => 2
            ]);

            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',"15:00:00"),
                'end'=> Carbon::createFromFormat('H:i:s',"16:00:00"),
                'auto'=> true,
                'type' => 2
            ]);

            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',"16:00:00"),
                'end'=> Carbon::createFromFormat('H:i:s',"17:00:00"),
                'auto'=> true,
                'type' => 2
            ]);

            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',"17:00:00"),
                'end'=> Carbon::createFromFormat('H:i:s',"18:00:00"),
                'auto'=> true,
                'type' => 3
            ]);

            Timetables::create([
                'start' => Carbon::createFromFormat('H:i:s',"17:00:00"),
                'end'=> Carbon::createFromFormat('H:i:s',"18:00:00"),
                'auto'=> true,
                'type' => 4
            ]);


            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
        }
    }
}
