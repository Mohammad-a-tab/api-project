<?php

namespace App\Traits;

trait JsonResponseTrait
{
    protected function successResponse($message = 'Success', $data = [], $statusCode = 200)
    {
        $response = [
            'success' => true,
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($response);
    }

    protected function errorResponse($message = 'Error', $statusCode = 400, $data = [])
    {
        if($statusCode == 400) {
            $transformedData = [];
            foreach ($data as $key => $value) {
                $transformedData[$key] = reset($value);
            }
            $data = json_decode(json_encode($transformedData));
        }
        $response = [
            'success' => false,
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($response);
    }
}
