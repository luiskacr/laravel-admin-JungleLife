<?php

namespace Database\Seeders;

use App\Models\ApprovalOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApprovalsOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApprovalOption::create([
            'name' => 'Abierto'
        ]);

        ApprovalOption::create([
            'name' => 'Rechazado'
        ]);

        ApprovalOption::create([
            'name' => 'Aprovado'
        ]);

        ApprovalOption::create([
            'name' => 'Cerrado'
        ]);

    }
}
