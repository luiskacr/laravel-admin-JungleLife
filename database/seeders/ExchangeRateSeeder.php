<?php

namespace Database\Seeders;

use App\Models\ExchangeRate;
use App\Traits\ExchangeRateTrait;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ExchangeRateSeeder extends Seeder
{
    use ExchangeRateTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run():void
    {
        try{
            ExchangeRate::create([
                'date' => Carbon::now('America/Costa_Rica'),
                'buy' => 0,
                'sell' => 0,
            ]);

            $this->createExchangeRate();
        }catch (\Exception $e){

        }
    }
}
