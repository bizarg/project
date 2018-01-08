<?php

use Illuminate\Database\Seeder;

class TariffsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tariffs')->insert([
            'name' => 'Standart',
            'value' => '15'
        ]);

        DB::table('tariffs')->insert([
            'name' => 'Universal',
            'value' => '50'
        ]);

        DB::table('tariffs')->insert([
            'name' => 'Individual'
        ]);
    }
}
