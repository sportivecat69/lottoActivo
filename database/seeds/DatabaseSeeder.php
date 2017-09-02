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
             'email' => 'g.tineo11@gmail.com',
             'password' => bcrypt('071194'),
             'lastname' => 'Tineo',
             'firstname' => 'Gregory',
             'documento' => 'V-24905754',
              'role' => 'ADMINISTRADOR'
         ]);
    }
}
