<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SizeRequest;
use App\Http\Resources\SizeResource;
use App\Models\Size;
use Illuminate\Http\JsonResponse;

class SizeController extends ApiController
{
    public function index(): JsonResponse
    {
        $sizes = Size::query()->orderBy('name')->get();

        return $this->success(SizeResource::collection($sizes)->resolve(request()));
    }

    public function store(SizeRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (Size::query()->where('name', $data['name'])->exists()) {
            return $this->error('La talla ya existe.', ['name' => ['La talla ya está registrada.']], 409);
        }

        $size = Size::query()->create($data);

        return $this->success((new SizeResource($size))->resolve(request()), 201);
    }

    public function show(Size $size): JsonResponse
    {
        return $this->success((new SizeResource($size))->resolve(request()));
    }

    public function update(SizeRequest $request, Size $size): JsonResponse
    {
        $data = $request->validated();

        if (Size::query()->where('name', $data['name'])->whereKeyNot($size->getKey())->exists()) {
            return $this->error('La talla ya existe.', ['name' => ['La talla ya está registrada.']], 409);
        }

        $size->update($data);

        return $this->success((new SizeResource($size->fresh()))->resolve(request()));
    }

    public function destroy(Size $size): JsonResponse
    {
        $size->delete();

        return $this->noContent();
    }
}
