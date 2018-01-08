<?php

namespace App;

use App\Builders\ApiResponse;
use App\Builders\ApiResponseBuilder;
use App\Builders\StatusResponseBuilder;
use App\Types\MessageType;
use App\Verifications\Verifiable;
use Illuminate\Database\Eloquent\Model;

class Status extends Model implements ApiResponse, ApiResponseBuilder, Verifiable
{
    protected $table = 'statuses';

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function get_params()
    {
        return [
            'status',
            'created_at'
        ];
    }
    public function build()
    {
        return (new StatusResponseBuilder($this))->build();
    }

    public function getType()
    {
        return MessageType::unavailable;
    }


}
