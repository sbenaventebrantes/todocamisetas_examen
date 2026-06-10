<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiController extends Controller
{
    protected function success(mixed $data, int $status = 200): JsonResponse
    {
        if ($data instanceof JsonResource) {
            return response()->json($data->resolve(request()), $status);
        }

        return response()->json($data, $status);
    }

    protected function error(string $message, array $errors = [], int $status = 400): JsonResponse
    {
        $payload = ['message' => $message];

        if ($errors !== []) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }

    protected function noContent(): JsonResponse
    {
        return response()->json(null, 204);
    }
}
