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
        $this->call(AddSettingsRow::class);
//        $this->call(ResolutionSeeder::class);
//        $this->call(BitrateSeeder::class);

    }
}
