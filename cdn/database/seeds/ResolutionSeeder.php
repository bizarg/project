<?php

use Illuminate\Database\Seeder;

class ResolutionSeeder extends Seeder
{
    public $resolutions = [
        ['weight' => 640, 'height' => 360],
        ['weight' => 720, 'height' => 480],
        ['weight' => 854, 'height' => 480],
        ['weight' => 1280, 'height' => 720],
        ['weight' => 1920, 'height' => 1080],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->resolutions as $resolution) {
            App\Resolution::create([
                'weight'  => $resolution['weight'],
                'height'  => $resolution['height']
            ]);
        }
    }
}
