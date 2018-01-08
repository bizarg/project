<?php

namespace App;

use App\Builders\ApiResponse;
use App\Builders\ApiResponseBuilder;
use App\Builders\ResponseBuilder;
use Illuminate\Database\Eloquent\Model;

class Message extends Model implements ApiResponse, ApiResponseBuilder
{
    protected $table = 'messages';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function site()
    {
        return $this->belongsTo('App\Site');
    }


    public function get_params()
    {
        return [
            'level',
            'status',
            'type',
            'created_at'
        ];
    }

    public function build()
    {
        return (new ResponseBuilder($this))->build();
    }
}
