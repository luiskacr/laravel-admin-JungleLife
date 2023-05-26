<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Tour de Peresos',
            'description' => '' ,
            'price' => 15,
            'type' => 1,
            'money' => 2,
        ]);


        Product::create([
            'name' => 'Tour de Peresos Kids',
            'description' => ' ' ,
            'price' => 10,
            'type' => 1,
            'money' => 2,
        ]);

        Product::create([
            'name' => 'Tour de Aves',
            'description' => '' ,
            'price' => 20,
            'type' => 1,
            'money' => 2,
        ]);


        Product::create([
            'name' => 'Tour de Aves Kids',
            'description' => ' ' ,
            'price' => 15,
            'type' => 1,
            'money' => 2,
        ]);
    }
}
