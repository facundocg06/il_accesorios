<?php

namespace App\Http\Responses;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success( string $message, $data=null, array $meta = [], int $status = 200): JsonResponse
    {
        $meta['timestamp'] = now()->toDateTimeString();
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'meta' => $meta
        ], $status);
    }

    //TODO: ver si mandar el error tambien??
    public static function error(string $message, $error = null, array $meta = [], int $status = 500): JsonResponse
    {
        $meta['timestamp'] = now()->toDateTimeString();
        return response()->json([
            'success' => false,
            'message'=>$message,
            'error' => $error,
            'meta' => $meta
        ], $status);
    }
}
