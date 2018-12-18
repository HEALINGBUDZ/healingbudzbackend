<?php

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(IconsTableSeeder::class);
        $this->call(DefaultQuestionsTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(StrainTypesTableSeeder::class);
        $this->call(StrainsTableSeeder::class);
        $this->call(SensationsTableSeeder::class);
        $this->call(NegativeEffectsTableSeeder::class);
        $this->call(MenuItemsTableSeeder::class);
        $this->call(MedicalConditionsTableSeeder::class);
        $this->call(ExpertiseQuestionsTableSeeder::class);
        $this->call(ExpertiesTableSeeder::class);
        $this->call(DiseasePreventionsTableSeeder::class);
        $this->call(BusinessTypesTableSeeder::class);

    }
}
