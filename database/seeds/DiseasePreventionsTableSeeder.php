<?php

use Illuminate\Database\Seeder;

class DiseasePreventionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('disease_preventions')->insert([
            ['prevention' => 'Neuroprotectant', 'is_approved' => 1],
            ['prevention' => 'Algheiner`s', 'is_approved' => 1],
            ['prevention' => 'Heart Disease', 'is_approved' => 1],
        ]);
    }
}
