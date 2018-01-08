<?php

namespace App;

use App\Builders\ApiResponse;
use App\Builders\ApiResponseBuilder;
use App\Builders\ResponseBuilder;
use App\Types\MessageType;
use App\Verifications\Verifiable;
use Illuminate\Database\Eloquent\Model;

class DomainExpire extends Model implements ApiResponse, ApiResponseBuilder, Verifiable
{
    protected $dates = [
        'expired',
    ];

    public function get_params()
    {
        return [
            'expired'
        ];
    }

    public function site()
    {
        return $this->belongsTo('App\Site');

    }

    public function build()
    {
        return (new ResponseBuilder($this))->build();
    }

    public function getType()
    {
        return MessageType::domain_expire;
    }
}
