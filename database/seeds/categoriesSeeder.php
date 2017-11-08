<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class categoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('categories')->insert([ # id 1
             'name' => 'Ruleta Activa',
             'description' => 'Lotto Activo',
             "created_at" =>  \Carbon\Carbon::now(), 
             "updated_at" => \Carbon\Carbon::now(),  
         ]);
    }
}
