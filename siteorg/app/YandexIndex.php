<?php

namespace App;

use App\Builders\ApiResponse;
use App\Builders\ApiResponseBuilder;
use App\Builders\ResponseBuilder;
use App\Types\MessageType;
use App\Verifications\Verifiable;
use Illuminate\Database\Eloquent\Model;

class YandexIndex extends Model implements ApiResponse, ApiResponseBuilder, Verifiable
{

    protected $table = 'yandex_index';

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function get_params()
    {
        return [
            'index',
            'created_at'
        ];
    }

    public function build()
    {
        return (new ResponseBuilder($this))->build();
    }

    public function getType()
    {
        return MessageType::yandex_index;
    }


}
