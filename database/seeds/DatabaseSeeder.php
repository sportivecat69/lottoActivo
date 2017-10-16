<?php

use Illuminate\Database\Seeder;

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
         
         \DB::table('roles')->insert([
	         'name' => 'rooter',
	         'display_name' => 'ADMIN',
	         'description' => 'Administrador de Sistema',
         ]);
         
         \DB::table('roles')->insert([
         		'name' => 'banker',
         		'display_name' => 'BANQUERO',
         		'description' => 'Administrador del Sitio',
         ]);
         
         \DB::table('roles')->insert([
         		'name' => 'seller',
         		'display_name' => 'VENDEDOR',
         		'description' => 'Administrador de Ventas',
         ]);
         
         \DB::table('role_user')->insert([
         'user_id' => 1,
         'role_id' => 1,
         ]);
    }
}
