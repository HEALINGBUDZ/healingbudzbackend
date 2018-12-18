<?php

use Illuminate\Database\Seeder;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('menu_items')->insert([
            ['item' => 'Activity Log'],
            ['item' => 'Message'],
            ['item' => 'My Journal'],
            ['item' => 'My Questions'],
            ['item' => 'My Answers'],
            ['item' => 'My Groups'],
            ['item' => 'My Strains'],
            ['item' => 'My Budz Map'],
            ['item' => 'My Rewards'],
            ['item' => 'My Saves'],
            ['item' => 'Shout Out'],
        ]);
    }
}
