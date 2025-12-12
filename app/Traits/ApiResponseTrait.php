<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function success($message, $data = [], $status = 200)
    {
        return response()->json(array_merge([
            'status' => $status,
            'message' => $message
        ], $data), $status);
    }

    public function error($message, $status = 500, $errors = [])
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'errors' => $errors
        ], $status);
    }
}
