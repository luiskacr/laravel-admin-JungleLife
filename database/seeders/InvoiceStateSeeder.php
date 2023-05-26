<?php

namespace Database\Seeders;

use App\Models\InvoiceState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InvoiceState::create([
            'name' => 'Abierta'
        ]);

        InvoiceState::create([
            'name' => 'Cerrada'
        ]);
    }
}
