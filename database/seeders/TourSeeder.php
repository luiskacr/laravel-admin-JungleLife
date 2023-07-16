<?php

namespace Database\Seeders;

use App\Models\Timetables;
use App\Models\Tour;
use App\Traits\TourTraits;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TourSeeder extends Seeder
{
    use tourTraits;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
            DB::beginTransaction();

            $timeTables = Timetables::all();
            $today = Carbon::now();
            $lastDay = $today->copy()->addYear();


            while ($today->lt($lastDay)) {

                foreach ($timeTables as $timeTable){
                    $this->creatTour($timeTable, $today, 1 , __('app.auto_system') );
                }

                $today->addDay();
            }

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
        }

    }
}
