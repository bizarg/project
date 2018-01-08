<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            'name' => 'Ordered',
            'color' => '#636b6f'
        ]);

        DB::table('statuses')->insert([
            'name' => 'Actived',
            'color' => '#15a000'
        ]);

        DB::table('statuses')->insert([
            'name' => 'Deactivated',
            'color' => '#e69900'
        ]);

        DB::table('statuses')->insert([
            'name' => 'Removed',
            'color' => '#f40700'
        ]);
    }
}
