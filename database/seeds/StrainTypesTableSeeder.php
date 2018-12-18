<?php

use Illuminate\Database\Seeder;

class StrainTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('strain_types')->insert([
            ['title' => 'Hybrid'],
            ['title' => 'Indica'],
            ['title' => 'Sativa'],
        ]);
    }
}
