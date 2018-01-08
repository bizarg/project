<?php

use Illuminate\Database\Seeder;

class BitrateSeeder extends Seeder
{
    public $bitrates = [
        '240k', '320k', '480k', '640k', '1200k'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->bitrates as $bitrate) {
            App\Bitrate::create([
                'bitrate'  => $bitrate
            ]);
        }
    }
}
