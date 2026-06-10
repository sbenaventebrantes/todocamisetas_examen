<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ShirtSizeRequest;
use App\Http\Requests\SyncShirtSizesRequest;
use App\Http\Resources\ShirtResource;
use App\Http\Resources\SizeResource;
use App\Models\Shirt;
use App\Models\Size;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShirtSizeController extends ApiController
{
    public function index(Shirt $shirt): JsonResponse
    {
        $shirt->load(['sizes']);

        return $this->success(SizeResource::collection($shirt->sizes)->resolve(request()));
    }

    public function store(ShirtSizeRequest $request, Shirt $shirt): JsonResponse
    {
        $data = $request->validated();
        $size = Size::query()->where('size_id', $data['sizeId'])->first();

        if (! $size) {
            return $this->error('La talla no existe.', [], 404);
        }

        if ($shirt->sizes()->whereKey($size->getKey())->exists()) {
            return $this->error('La talla ya está asociada a la camiseta.', ['sizeId' => ['La talla ya está asociada a esta camiseta.']], 409);
        }

        DB::table('shirt_sizes')->insert([
            'shirt_size_id' => (string) Str::uuid(),
            'shirt_id' => $shirt->getKey(),
            'size_id' => $size->getKey(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $this->success((new ShirtResource($shirt->fresh()->load(['customer', 'sizes'])))->resolve(request()));
    }

    public function update(SyncShirtSizesRequest $request, Shirt $shirt): JsonResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($shirt, $data): void {
            $shirt->sizes()->sync($data['sizeIds']);
        });

        return $this->success((new ShirtResource($shirt->fresh()->load(['customer', 'sizes'])))->resolve(request()));
    }

    public function destroy(Shirt $shirt, Size $size): JsonResponse
    {
        if (! $shirt->sizes()->whereKey($size->getKey())->exists()) {
            return $this->error('La talla no está asociada a la camiseta.', [], 404);
        }

        DB::table('shirt_sizes')
            ->where('shirt_id', $shirt->getKey())
            ->where('size_id', $size->getKey())
            ->delete();

        return $this->noContent();
    }
}
