<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function success($message, $data = null, $status = 200)
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    public function error($message, $status = 500, $errors = null)
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }
}
