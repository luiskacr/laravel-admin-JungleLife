<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
            DB::beginTransaction();

            Role::create(['name' => 'Administrador']);
            Role::create(['name' => 'Operador']);
            Role::create(['name' => 'Tour Operador']);


            DB::table('users')->insert([
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'avatars' => null,
                'active' => true,
                'password'=> bcrypt('admin'),
            ]);

            $user = User::find(1);
            $user->assignRole('Administrador');

            DB::commit();

        }catch (\Exception $e){
            DB::rollback();
        }
    }
}
