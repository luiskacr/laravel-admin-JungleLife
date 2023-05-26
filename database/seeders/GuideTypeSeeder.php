<?php

namespace Database\Seeders;

use App\Models\GuidesType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuideTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GuidesType::create([
            'name' => 'Interno'
        ]);

        GuidesType::create([
            'name' => 'Externo'
        ]);
    }
}
