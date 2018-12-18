<?php

use Illuminate\Database\Seeder;

class MedicalConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('medical_conditions')->insert([
            ['m_condition' => 'Heart Disease', 'is_approved' => 1],
            ['m_condition' => 'Heart Condition', 'is_approved' => 1],
        ]);
    }
}
