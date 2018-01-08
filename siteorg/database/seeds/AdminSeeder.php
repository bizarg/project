<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'admin',
            'email' => 'admin@admin',
            'password' => bcrypt('gEjU1D'),
            'email' => 'admin@admin',
        ]);
    }
}
