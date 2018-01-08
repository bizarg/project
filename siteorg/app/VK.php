<?php

namespace App;

use App\Builders\ApiResponse;
use App\Builders\ApiResponseBuilder;
use App\Builders\ResponseBuilder;
use Illuminate\Database\Eloquent\Model;

class VK extends Model implements ApiResponse, ApiResponseBuilder
{
    protected $table = 'vk';

    public function site()
    {
        return $this->belongsTo('App\Site');

    }

    public function get_params()
    {
        return [
            'likes',
            'created_at'
        ];
    }


    public function build()
    {
        return (new ResponseBuilder($this))->build();
    }
}
