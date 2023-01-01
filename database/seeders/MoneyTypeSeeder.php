<?php

namespace Database\Seeders;

use App\Models\MoneyType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MoneyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MoneyType::create([
            'name'=> 'Colones',
            'symbol'=> '₡'
        ]);
        MoneyType::create([
            'name'=> 'Dolares',
            'symbol'=> '$'
        ]);
    }
}
