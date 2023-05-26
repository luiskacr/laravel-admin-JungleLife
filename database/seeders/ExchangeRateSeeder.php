<?php

namespace Database\Seeders;

use App\Models\ExchangeRate;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $urlRoot = env("API_TIPO_CAMBIO");
        $today= Carbon::now('America/Costa_Rica');
        $api = $urlRoot. $today->day .'/'. $today->month .'/'. $today->year;

        //Get Info from the API
        $request = Http::get($api)->json();
        ExchangeRate::create([
            'date' => $today,
            'buy' => $request['compra'],
            'sell' => $request['venta'],
        ]);

    }
}
