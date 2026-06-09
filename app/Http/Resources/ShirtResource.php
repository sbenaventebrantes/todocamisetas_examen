<?php

namespace App\Http\Resources;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShirtResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $customer = $this->resolveConsultingCustomer($request);
        $sizes = $this->relationLoaded('sizes') ? SizeResource::collection($this->sizes)->resolve($request) : [];

        return [
            'productId' => $this->product_id,
            'customerId' => $this->customer_id,
            'title' => $this->title,
            'club' => $this->club,
            'country' => $this->country,
            'type' => $this->type,
            'color' => $this->color,
            'price' => (float) $this->price,
            'priceOffer' => $this->price_offer !== null ? (float) $this->price_offer : null,
            'details' => $this->details,
            'productCode' => $this->product_code,
            'finalPrice' => $this->resolveFinalPrice($customer),
            'sizes' => $sizes,
            'createdAt' => $this->created_at?->copy()->timezone(config('app.timezone'))->format('Y-m-d\TH:i:s.uP'),
            'updatedAt' => $this->updated_at?->copy()->timezone(config('app.timezone'))->format('Y-m-d\TH:i:s.uP'),
        ];
    }

    private function resolveConsultingCustomer(Request $request): ?Customer
    {
        $consultingCustomer = $this->getRelationValue('consultingCustomer');

        if ($consultingCustomer instanceof Customer) {
            return $consultingCustomer;
        }

        $routeCustomer = $request->route('customer');

        if ($routeCustomer instanceof Customer) {
            return $routeCustomer;
        }

        $customerId = $request->query('customerId');

        if (! $customerId) {
            return null;
        }

        return Customer::query()->find($customerId);
    }

    private function resolveFinalPrice(?Customer $customer): float
    {
        if ($customer?->isPreferential() && $this->price_offer !== null) {
            return (float) $this->price_offer;
        }

        return (float) $this->price;
    }
}
