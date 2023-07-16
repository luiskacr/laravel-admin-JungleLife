<?php

namespace Database\Seeders;

use App\Models\ClientType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClientType::create([
            'name' => 'Regular Nacional'
        ]);

        ClientType::create([
            'name' => 'Agencia'
        ]);

        ClientType::create([
            'name' => 'Regular Extranjero'
        ]);

        ClientType::create([
            'name' => 'CPL'
        ]);
    }
}
