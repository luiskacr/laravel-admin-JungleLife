<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentType::create([
            'name' => 'Efectivo'
        ]);

        PaymentType::create([
            'name' => 'Transferencia Bancaria'
        ]);

        PaymentType::create([
            'name' => 'Tarjeta de Credito o Debito'
        ]);

        PaymentType::create([
            'name' => 'Credito'
        ]);

        PaymentType::create([
            'name' => 'Web'
        ]);
    }
}
