<?php

use Illuminate\Database\Seeder;

class NegativeEffectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('negative_effects')->insert([
            ['effect' => 'Mucus', 'is_approved' => 1],
            ['effect' => 'Allergy', 'is_approved' => 1],
            ['effect' => 'Headache', 'is_approved' => 1],
            ['effect' => 'Less REM sleep', 'is_approved' => 1],
            ['effect' => 'Tar buildup  ', 'is_approved' => 1],
        ]);
    }
}
