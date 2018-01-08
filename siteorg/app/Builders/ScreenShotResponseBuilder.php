<?php
namespace App\Builders;


class ScreenShotResponseBuilder implements ApiResponseBuilder
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
            if ($k == 'screenshot') {
                $response['url'] = $v;
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