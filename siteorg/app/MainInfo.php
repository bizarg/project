<?php

namespace App;

use App\Builders\ApiResponse;
use App\Builders\ApiResponseBuilder;
use App\Builders\ResponseBuilder;
use Illuminate\Database\Eloquent\Model;

class MainInfo extends Model implements ApiResponse, ApiResponseBuilder
{ 
    protected $table = 'main_info';

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function get_params()
    {
        return [
            'title',
            'keywords',
            'description',
            'cms',
            'favicon',
            'status',
            'server',
            'ip',
            'country',
            'city',
            'time_zone',
            'css_framework',
            'js_framework',
            'valid_html',
            'yandex_metrica',
            'google_analytics',
            'expiry_date'
        ];
    }

    public function build()
    {
        return (new ResponseBuilder($this))->build();
    }
}
