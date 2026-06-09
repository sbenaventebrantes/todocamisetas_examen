<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyncShirtSizesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sizeIds' => ['required', 'array', 'min:1'],
            'sizeIds.*' => ['uuid', 'exists:sizes,size_id'],
        ];
    }

    public function messages(): array
    {
        return [
            'sizeIds.required' => 'Debes enviar al menos una talla.',
            'sizeIds.array' => 'Las tallas deben enviarse como una lista.',
            'sizeIds.min' => 'Debes enviar al menos una talla.',
            'sizeIds.*.exists' => 'Una o más tallas no existen.',
        ];
    }
}
