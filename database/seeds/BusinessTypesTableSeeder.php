<?php

use Illuminate\Database\Seeder;

class BusinessTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('business_types')->insert([
            ['title' => 'Dispensary'],
            ['title' => 'Medical Practitioner'],
            ['title' => 'Cannabites'],
            ['title' => 'Lounge'],
            ['title' => 'Events'],
            ['title' => 'Holistic Medical'],
            ['title' => 'Clinic'],
            ['title' => 'Cannabis Club/Bar'],
        ]);
    }
}
