<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Configuration::create([
            'name'=> 'Clientes por Tour',
            'data'=> [
                'value' => 12
            ]
        ]);
        Configuration::create([
            'name'=> 'Creacion Automatica de Tours',
            'data'=> [
                'value' => true
            ]
        ]);
        Configuration::create([
            'name'=> 'Cierre automatico de Tours',
            'data'=> [
                'value' => true
            ]
        ]);
    }
}
