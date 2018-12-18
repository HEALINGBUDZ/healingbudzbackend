<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('tags')->insert([
            ['title' => 'cannibis oil' , 'is_approved' => 1],
            ['title' => 'sleep' , 'is_approved' => 1],
            ['title' => 'test1' , 'is_approved' => 1],

        ]);
    }
}
