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
        $this->call(UserSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(EmailTypes::class);
        $this->call(EmailDefaultTemplates::class);
        $this->call(ProxyGoogle::class);
        $this->call(ProxyWhois::class);


    }
}
