<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'customerId' => $this->customer_id,
            'tradeName' => $this->trade_name,
            'taxId' => $this->tax_id,
            'address' => $this->address,
            'category' => $this->category,
            'contactName' => $this->contact_name,
            'contactEmail' => $this->contact_email,
            'offerPercentage' => $this->offer_percentage !== null ? (float) $this->offer_percentage : null,
            'createdAt' => $this->created_at?->copy()->timezone(config('app.timezone'))->format('Y-m-d\TH:i:s.uP'),
            'updatedAt' => $this->updated_at?->copy()->timezone(config('app.timezone'))->format('Y-m-d\TH:i:s.uP'),
        ];
    }
}
