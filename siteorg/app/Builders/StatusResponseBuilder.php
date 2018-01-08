<?php
namespace App\Builders;


use Illuminate\Support\Facades\Log;

class StatusResponseBuilder implements ApiResponseBuilder
{

    private $apiResponse;

    /**
     * ApiResponseBuilder constructor.
     */
    public function __construct(ApiResponse $apiResponse)
    {
        $this->apiResponse = $apiResponse;

    }

    public function build()
    {
        $response = [];

        $decoder = $function = function ($k, $v) {
            $response = [];
            if ($k == 'status') {
                $response = json_decode($v, true);
            } else {
                $response[$k] = $v;

            }
            return $response;
        };
        foreach ($this->apiResponse->get_params() as $field) {
            $arr = $decoder ($field, $this->apiResponse->{$field});
            $response = array_merge($arr, $response);
        }
        return $response;
    }


}