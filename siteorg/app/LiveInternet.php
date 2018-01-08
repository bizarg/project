<?php

namespace App;

use App\Builders\ApiResponse;
use App\Builders\ApiResponseBuilder;
use App\Builders\ResponseBuilder;
use Illuminate\Database\Eloquent\Model;

class LiveInternet extends Model implements ApiResponse, ApiResponseBuilder
{

    protected $table = 'liveinternet';

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function get_params()
    {
        return [
            'li_month_hit',
            'li_month_vis',
            'li_week_hit',
            'li_week_vis',
            'li_day_hit',
            'li_day_vis',
            'li_today_hit',
            'li_today_vis',
            'li_online_hit',
            'li_online_vis',
            'li_error',
            'created_at'
        ];
    }

    public function build()
    {
        return (new ResponseBuilder($this))->build();
    }
}
