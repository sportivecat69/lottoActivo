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
              'role' => 'ADMINISTRADOR'
         ]);
    }
}
