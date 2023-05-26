<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExchangeRate extends Command
{
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
    public function handle()
    {
        try{
            //Construct the Api URL
            $urlRoot = env("API_TIPO_CAMBIO");
            $today= Carbon::now('America/Costa_Rica');
            $api = $urlRoot. $today->day .'/'. $today->month .'/'. $today->year;

            //Get Info from the API
            $request = Http::get($api)->json();


            \App\Models\ExchangeRate::create([
                'date' => $today,
                'buy' => $request['compra'],
                'sell' => $request['venta'],
            ]);

            return Command::SUCCESS;

        }catch (\Exception $e){
            Log::channel('cronJobs')->info('Date: ' .Carbon::now('America/Costa_Rica'));
            Log::channel('cronJobs')->info('Process Error:exchange-rate:get');
            Log::channel('cronJobs')->error($e);
            Log::channel('cronJobs')->info('End');
            Log::channel('cronJobs')->info(' ');

            return Command::FAILURE;
        }
    }
}
