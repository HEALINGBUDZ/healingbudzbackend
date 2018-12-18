<?php

use Illuminate\Database\Seeder;

class ExpertiseQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('expertise_questions')->insert([
            ['question' => 'Which conditions or ailments have you treated with cannabis?'],
            ['question' => 'What marijuana strains do you have experience with?'],

        ]);
    }
}
