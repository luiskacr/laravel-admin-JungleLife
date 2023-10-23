<?php

namespace App\Traits;

use App\Models\ExchangeRate;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

trait ExchangeRateTrait
{

    /**
     * Search for an actual Exchange Rate value from URL
     *
     * @return void
     * @throws Exception
     */
    public function createExchangeRate():void
    {
        DB::beginTransaction();
        try{
            $urlRoot = env("API_TIPO_CAMBIO");
            $today= Carbon::now('America/Costa_Rica');
            //$api = $urlRoot. $today->day .'/'. $today->month .'/'. $today->year;

            $request = Http::get($urlRoot)->json();

            ExchangeRate::create([
                'date' => $today,
                'buy' => $request['compra']['valor'],
                'sell' => $request['venta']['valor'],
            ]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            throw new Exception( $e->getMessage());
        }
    }

}
