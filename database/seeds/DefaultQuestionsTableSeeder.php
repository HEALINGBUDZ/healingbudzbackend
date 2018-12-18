<?php

use Illuminate\Database\Seeder;

class DefaultQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('default_questions')->insert([
            ['question' => 'Should I warm cannabis oil before applying?' , 'answer' => 'I’m using cannabis oil. For muscle pain therapy and I’m unsure if I should warm it before rubbing it on the effected areas.' , 'image_path' => ''],

        ]);
    }
}
