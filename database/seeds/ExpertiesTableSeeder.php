<?php

use Illuminate\Database\Seeder;

class ExpertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('experties')->insert([
            ['title' => 'Canker Sores', 'exp_question_id' => 1],
            ['title' => 'Muscle Spasms', 'exp_question_id' => 1],
            ['title' => 'Insomnia', 'exp_question_id' => 1],
            ['title' => 'Skin Rash', 'exp_question_id' => 1],
            ['title' => 'OG Kush', 'exp_question_id' => 2],
            ['title' => 'Capri Sunset', 'exp_question_id' => 2],
            ['title' => 'Girl Scout Cookies', 'exp_question_id' => 2],
            ['title' => 'Blueberry Dream', 'exp_question_id' => 2],
            ['title' => 'Hazyhash', 'exp_question_id' => 2],

        ]);
    }
}
