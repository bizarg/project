<?php

use Illuminate\Database\Seeder;

class DomensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('domens')->insert([
            'name' => 'test.in',
            // 'description' => 'description one project',
        ]);
    }
}
