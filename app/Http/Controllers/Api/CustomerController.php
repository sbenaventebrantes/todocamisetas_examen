<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\ShirtResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class CustomerController extends ApiController
{
    public function index(): JsonResponse
    {
        $customers = Customer::query()->orderBy('trade_name')->get();

        return $this->success(CustomerResource::collection($customers)->resolve(request()));
    }

    public function store(CustomerRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (Customer::query()->where('tax_id', $data['taxId'])->exists()) {
            return $this->error('El cliente ya existe.', ['taxId' => ['El documento fiscal ya está registrado.']], 409);
        }

        $customer = Customer::query()->create([
            'trade_name' => $data['tradeName'],
            'tax_id' => $data['taxId'],
            'address' => $data['address'] ?? null,
            'category' => $data['category'],
            'contact_name' => $data['contactName'],
            'contact_email' => $data['contactEmail'],
            'offer_percentage' => $data['offerPercentage'] ?? null,
        ]);

        return $this->success((new CustomerResource($customer->fresh()))->resolve(request()), 201);
    }

    public function show(Customer $customer): JsonResponse
    {
        return $this->success((new CustomerResource($customer))->resolve(request()));
    }

    public function update(CustomerRequest $request, Customer $customer): JsonResponse
    {
        $data = $request->validated();

        if (Customer::query()->where('tax_id', $data['taxId'])->whereKeyNot($customer->getKey())->exists()) {
            return $this->error('El cliente ya existe.', ['taxId' => ['El documento fiscal ya está registrado.']], 409);
        }

        $customer->update([
            'trade_name' => $data['tradeName'],
            'tax_id' => $data['taxId'],
            'address' => $data['address'] ?? null,
            'category' => $data['category'],
            'contact_name' => $data['contactName'],
            'contact_email' => $data['contactEmail'],
            'offer_percentage' => $data['offerPercentage'] ?? null,
        ]);

        return $this->success((new CustomerResource($customer->fresh()))->resolve(request()));
    }

    public function destroy(Customer $customer): JsonResponse
    {
        if ($customer->shirts()->exists()) {
            return $this->error('No se puede eliminar el cliente porque tiene camisetas asociadas.', [], 409);
        }

        $customer->delete();

        return $this->noContent();
    }

    public function shirts(string $customerId): JsonResponse
    {
        $customer = Customer::query()->where('customer_id', $customerId)->first();

        if (! $customer) {
            return $this->error('No encontrado.', [], 404);
        }

        $shirts = $customer->shirts()->with('sizes')->orderBy('title')->get();

        return $this->success(ShirtResource::collection($shirts)->resolve(request()));
    }
}
