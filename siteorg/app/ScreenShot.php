<?php

namespace App;

use App\Builders\ApiResponse;
use App\Builders\ApiResponseBuilder;
use App\Builders\ScreenShotResponseBuilder;
use Illuminate\Database\Eloquent\Model;

class ScreenShot extends Model implements ApiResponse, ApiResponseBuilder
{
    protected $table = 'screenshots';

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function get_params()
    {
        return [
            'screenshot',
            'created_at'
        ];
    }
    public function build()
    {
        return (new ScreenShotResponseBuilder($this))->build();
    }
}
