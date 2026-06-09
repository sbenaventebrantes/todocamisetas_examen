<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ShirtRequest;
use App\Http\Resources\ShirtResource;
use App\Models\Customer;
use App\Models\Shirt;
use Illuminate\Http\JsonResponse;

class ShirtController extends ApiController
{
    public function index(): JsonResponse
    {
        $shirts = Shirt::query()->with(['customer', 'sizes'])->orderBy('title')->get();

        return $this->success(ShirtResource::collection($shirts)->resolve(request()));
    }

    public function store(ShirtRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (Shirt::query()->where('product_code', $data['productCode'])->exists()) {
            return $this->error('La camiseta ya existe.', ['productCode' => ['El código de producto ya está registrado.']], 409);
        }

        $shirt = Shirt::query()->create([
            'customer_id' => $data['customerId'],
            'title' => $data['title'],
            'club' => $data['club'],
            'country' => $data['country'],
            'type' => $data['type'],
            'color' => $data['color'],
            'price' => $data['price'],
            'price_offer' => $data['priceOffer'] ?? null,
            'details' => $data['details'] ?? null,
            'product_code' => $data['productCode'],
        ]);

        return $this->success((new ShirtResource($shirt->load(['customer', 'sizes'])))->resolve(request()), 201);
    }

    public function show(Shirt $shirt): JsonResponse
    {
        $customerId = request()->query('customerId');

        if ($customerId !== null && ! Customer::query()->whereKey($customerId)->exists()) {
            return $this->error('El cliente no existe.', [], 404);
        }

        $shirt->load(['customer', 'sizes']);
        if ($customerId !== null) {
            $shirt->setRelation('consultingCustomer', Customer::query()->where('customer_id', $customerId)->first());
        }

        return $this->success((new ShirtResource($shirt))->resolve(request()));
    }

    public function update(ShirtRequest $request, Shirt $shirt): JsonResponse
    {
        $data = $request->validated();

        if (Shirt::query()->where('product_code', $data['productCode'])->whereKeyNot($shirt->getKey())->exists()) {
            return $this->error('La camiseta ya existe.', ['productCode' => ['El código de producto ya está registrado.']], 409);
        }

        $shirt->update([
            'customer_id' => $data['customerId'],
            'title' => $data['title'],
            'club' => $data['club'],
            'country' => $data['country'],
            'type' => $data['type'],
            'color' => $data['color'],
            'price' => $data['price'],
            'price_offer' => $data['priceOffer'] ?? null,
            'details' => $data['details'] ?? null,
            'product_code' => $data['productCode'],
        ]);

        return $this->success((new ShirtResource($shirt->fresh()->load(['customer', 'sizes'])))->resolve(request()));
    }

    public function destroy(Shirt $shirt): JsonResponse
    {
        $shirt->delete();

        return response()->noContent();
    }
}
