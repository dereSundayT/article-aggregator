<?php

use Illuminate\Http\JsonResponse;

/**
 * @description: This function is used to return success response
 * @param string $message
 * @param mixed $data
 * @param int $statusCode
 * @return JsonResponse
 */
function successResponse(string $message, mixed $data, int $statusCode = 200): JsonResponse
{
    return response()->json([
        'status' => true,
        'message' => $message,
        'data' => $data
    ], $statusCode);
}


/**
 * @description: This function is used to return error response
 * @param string $message
 * @param mixed $data
 * @param int $statusCode
 * @return JsonResponse
 */
function errorResponse(string $message, mixed $data, int $statusCode = 400): JsonResponse
{
    return response()->json([
        'status' => false,
        'message' => $message,
        'data' => $data
    ], $statusCode);
}


