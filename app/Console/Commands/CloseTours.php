<?php

namespace App\Console\Commands;

use App\Models\Configuration;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CloseTours extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tours:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Review all tours in process and close those that are open.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $config = Configuration::find(3); // Validate if the automatic Option is Enable
            $isActive = $config->data['value'];

            if($isActive){
                $date = \Carbon\Carbon::now('America/Costa_Rica')->format('Y-m-d H:i:s');

                $openTours = \App\Models\Tour::all()
                    ->where("state", "=",1)
                    ->where('end','<', $date);

                foreach ($openTours as $tour){
                    $tour->update([
                        'state' => 2
                    ]);
                }
            }

            return Command::SUCCESS;
        }catch (\Exception $e){
            Log::channel('cronJobs')->info('Date: ' .Carbon::now('America/Costa_Rica'));
            Log::channel('cronJobs')->info('Process Error:tours:close');
            Log::channel('cronJobs')->error($e);
            Log::channel('cronJobs')->info('End');
            Log::channel('cronJobs')->info(' ');

            return Command::FAILURE;
        }

    }
}
