<?php

use Illuminate\Database\Seeder;

class SensationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('sensations')->insert([
            ['sensation' => 'Hunger' , 'is_approved' => 1],
            ['sensation' => 'Happiness' , 'is_approved' => 1],
            ['sensation' => 'Horny' , 'is_approved' => 1],
            ['sensation' => 'Paranoid' , 'is_approved' => 1],
        ]);
    }
}
