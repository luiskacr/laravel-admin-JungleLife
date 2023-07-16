<?php

namespace App\Console\Commands;

use App\Traits\ExchangeRateTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DailyExchangeRate extends Command
{
    use ExchangeRateTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange-rate:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This gets from the defined Api the exchange amount for the Dolar and stores it in the database. ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle():int
    {
        try{

            $this->createExchangeRate();

        }catch (\Exception $e){
            Log::channel('cronJobs')->info('Date: ' .Carbon::now('America/Costa_Rica'));
            Log::channel('cronJobs')->info('Process Error:exchange-rate:get');
            Log::channel('cronJobs')->error($e);
            Log::channel('cronJobs')->info('End');
            Log::channel('cronJobs')->info(' ');

            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
