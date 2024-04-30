<?php

namespace App\Helpers;

class ApiFormatter{
    protected static $response = [
        'code'      => null,
        'message'   => null,
        'data'      => [],
    ];

    public static function createJson ($code, $message, $data = []){
        self::$response['code']     = $code;
        self::$response['message']  = $message;
        self::$response['data']     = $data;

        return response()->json(self::$response, self::$response['code']);
    } 
}