<?php

namespace App;

use App\Builders\ApiResponse;
use App\Builders\ApiResponseBuilder;
use App\Builders\ResponseBuilder;
use Illuminate\Database\Eloquent\Model;

class AlexaRank extends Model implements ApiResponse, ApiResponseBuilder
{
    protected $table = 'alexa_ranks';

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function get_params()
    {
        return [
            'global_rank',
            'country_rank',
            'bounce_rate',
            'daily_ppv',
            'daily_tos',
            'sev',
            'traffic',
            'created_at'
        ];
    }

    public function build()
    {
        return (new ResponseBuilder($this))->build();
    }
}
