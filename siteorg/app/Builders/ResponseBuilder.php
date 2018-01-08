<?php
namespace App\Builders;


use Illuminate\Support\Facades\Log;

class ResponseBuilder implements ApiResponseBuilder
{

    private $apiResponse;

//    public static function build(ApiResponse $params, callable $func = null)
//    {
//        $response = [];
//
//        foreach ($params->get_params() as $field) {
//            if (is_null($func)) {
//                $response[$field] = $params[$field];
//            } else {
//                $arr = $func($field, $params[$field]);
//                $response = array_merge($arr, $response);
//            }
//        }
//        return $response;
//    }
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

        foreach ($this->apiResponse->get_params() as $field) {
            // if (is_null($func)) {
            $response[$field] = $this->apiResponse->{$field};

            //} else {
            //    $arr = $func($field, $params[$field]);
            //   $response = array_merge($arr, $response);
            //}
        }
        return $response;
    }
}