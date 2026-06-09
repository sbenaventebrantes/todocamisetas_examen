<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SizeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'sizeId' => $this->size_id,
            'name' => $this->name,
            'createdAt' => $this->created_at?->copy()->timezone(config('app.timezone'))->format('Y-m-d\TH:i:s.uP'),
            'updatedAt' => $this->updated_at?->copy()->timezone(config('app.timezone'))->format('Y-m-d\TH:i:s.uP'),
        ];
    }
}
