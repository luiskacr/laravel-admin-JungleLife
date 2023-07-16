<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Console\Commands\DailyExchangeRate;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(MoneyTypeSeeder::class);
        $this->call(TourStateSeeder::class);
        $this->call(TourTypeSeeder::class);
        $this->call(ConfigSeeder::class);
        $this->call(InvoiceStateSeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(ClientTypeSeeder::class);
        $this->call(GuideTypeSeeder::class);
        $this->call(ProductTypeSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ExchangeRateSeeder::class);
        $this->call(TimeTableSeeder::class);
        $this->call(TourSeeder::class);
        $this->call(ApprovalsOptionsSeeder::class);
    }
}
