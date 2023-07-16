<?php

namespace App\Console\Commands;

use App\Models\Timetables;
use App\Traits\TourTraits;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateTours extends Command
{
    use tourTraits;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tours:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically creates the toures depending on the configurations ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle():int
    {

        try{
            DB::beginTransaction();

            $timeTables = Timetables::all();
            $today = Carbon::now()->addYear();

            foreach ($timeTables as $timeTable){
                if($timeTable->auto){
                    $this->creatTour($timeTable, $today, 1 , __('app.auto_system') );
                }
            }

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();

            Log::channel('cronJobs')->info('Date: ' .Carbon::now('America/Costa_Rica'));
            Log::channel('cronJobs')->info('Process Error:tours:create');
            Log::channel('cronJobs')->error($e);
            Log::channel('cronJobs')->info('End');
            Log::channel('cronJobs')->info(' ');

            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
