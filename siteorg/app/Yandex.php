<?php

namespace App;

use App\Builders\ApiResponse;
use App\Builders\ApiResponseBuilder;
use App\Builders\ResponseBuilder;
use Illuminate\Database\Eloquent\Model;

class Yandex extends Model implements ApiResponse, ApiResponseBuilder
{
    protected $table = 'yandex';

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function get_params()
    {
        return [
            'yaca',
            'yaca_theme',
            'tic'
        ];
    }


    public function build()
    {
        return (new ResponseBuilder($this))->build();
    }
}
