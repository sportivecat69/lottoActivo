<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $user = factory(App\User::class)->create([
             'email' => 'admin@gmail.com',
             'password' => bcrypt('admin'),
             'lastname' => 'Mr.',
             'firstname' => 'Admin',
             'documento' => 'V-00000000',
             //'role' => 'ADMINISTRADOR'
         ]);
         

         DB::table('roles')->insert([
         'name' => 'rooter',
         'display_name' => 'ADMIN',
         'description' => 'Administrador de Sistema',

         ]);
         
         DB::table('role_user')->insert([
         'user_id' => 1,
         'role_id' => 1,
         ]);
    }
}
