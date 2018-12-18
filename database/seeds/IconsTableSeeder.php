<?php

use Illuminate\Database\Seeder;

class IconsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('icons')->insert([
            ['name' => '/icons/1.png'],
            ['name' => '/icons/2.png'],
            ['name' => '/icons/3.png'],
            ['name' => '/icons/4.png'],
            ['name' => '/icons/4.png']
        ]);
    }
}
