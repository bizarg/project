<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AddSettingsRow extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'domain' => 'api.dev-ops.cf',
            'link_format' => 'format',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
