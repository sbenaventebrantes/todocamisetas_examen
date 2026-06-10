<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ShirtController;
use App\Http\Controllers\Api\ShirtSizeController;
use App\Http\Controllers\Api\SizeController;
use Illuminate\Support\Facades\Route;

Route::get('health', function () {
    return response()->json([
        'message' => 'TodoCamisetas API funcionando',
        'data' => [
            'status' => 'ok',
        ],
    ]);
});

Route::get('swagger.yaml', function () {
    return response()->file(base_path('docs/openapi.yaml'), [
        'Content-Type' => 'text/yaml; charset=UTF-8',
    ]);
});

Route::apiResource('customers', CustomerController::class);
Route::get('customers/{customerId}/shirts', [CustomerController::class, 'shirts']);

Route::apiResource('shirts', ShirtController::class);

Route::get('shirts/{shirt}/sizes', [ShirtSizeController::class, 'index']);
Route::post('shirts/{shirt}/sizes', [ShirtSizeController::class, 'store']);
Route::put('shirts/{shirt}/sizes', [ShirtSizeController::class, 'update']);
Route::delete('shirts/{shirt}/sizes/{size}', [ShirtSizeController::class, 'destroy']);

Route::apiResource('sizes', SizeController::class);
