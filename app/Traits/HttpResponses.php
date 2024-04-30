<?php

namespace App\Traits;

trait HttpResponses //for creating traits in laravel, we should to write "trait" keyword at first
//Traits need for creating simple functions or functions that will replace big code
// just think that trait is a replacer for helpers.
//Triat creates without artisan that is why you should create it yourself 
{
    protected function success($data, $message = null, $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,

        ], $code);
    }


    protected function error($data, $code, $message = null )
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,

        ], $code);
    }
}
