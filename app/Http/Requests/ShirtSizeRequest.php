<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShirtSizeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sizeId' => ['required', 'uuid', 'exists:sizes,size_id'],
        ];
    }

    public function messages(): array
    {
        return [
            'sizeId.required' => 'La talla es obligatoria.',
            'sizeId.exists' => 'La talla no existe.',
        ];
    }
}
