<?php

use Illuminate\Database\Seeder;

class StrainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('strains')->insert([
            ['type_id' => 1 , 'title' => 'Cactus','overview' =>'test review' , 'approved' => ''],
            ['type_id' => 2 , 'title' => 'Girls Scout Ot','overview' =>'test overview 2' , 'approved' => 1],
            ['type_id' => 3 , 'title' => 'Girls Scout Ot2','overview' =>'test overview 3' , 'approved' => 1],
            ['type_id' => 1 , 'title' => 'Girls Scout Ot3','overview' =>'test overview 3' , 'approved' => 1],
            ['type_id' => 2 , 'title' => 'Girls Scout Ot4','overview' =>'test overview 4' , 'approved' => 1],

        ]);
    }
}
