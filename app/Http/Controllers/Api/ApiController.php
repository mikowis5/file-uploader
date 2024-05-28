<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class ApiController extends Controller
{
    protected function fail(string $message, int $status = 500): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $status);
    }
}
