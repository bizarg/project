<?php

use Illuminate\Database\Seeder;

class EmailTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $types = [
            [
                'id' => 1,
                'name' => \App\Types\MessageType::yandex_index,
            ],
            [
                'id' => 2,
                'name' => \App\Types\MessageType::google_index,
            ],
            [
                'id' => 3,
                'name' => \App\Types\MessageType::roskomnadzor,
            ],
            [
                'id' => 4,
                'name' => \App\Types\MessageType::ssl_expire,
            ],
            [
                'id' => 5,
                'name' => \App\Types\MessageType::unavailable,
            ],
            [
                'id' => 6,
                'name' => \App\Types\MessageType::virus_found,
            ],
            [
                'id' => 7,
                'name' => \App\Types\MessageType::domain_expire,
            ],
        ];
        DB::table('email_types')->insert($types);
    }
}
