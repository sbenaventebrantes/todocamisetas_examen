<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShirtRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customerId' => ['required', 'uuid', 'exists:customers,customer_id'],
            'title' => ['required', 'string', 'max:255'],
            'club' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:100'],
            'color' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'priceOffer' => ['nullable', 'numeric', 'min:0'],
            'details' => ['nullable', 'string'],
            'productCode' => ['required', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'customerId.required' => 'El cliente es obligatorio.',
            'customerId.exists' => 'El cliente no existe.',
            'title.required' => 'El título es obligatorio.',
            'club.required' => 'El club es obligatorio.',
            'country.required' => 'El país es obligatorio.',
            'type.required' => 'El tipo es obligatorio.',
            'color.required' => 'El color es obligatorio.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'price.min' => 'El precio no puede ser menor que 0.',
            'priceOffer.numeric' => 'El precio de oferta debe ser un número.',
            'priceOffer.min' => 'El precio de oferta no puede ser menor que 0.',
            'productCode.required' => 'El código de producto es obligatorio.',
        ];
    }
}
