<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tradeName' => ['required', 'string', 'max:255'],
            'taxId' => ['required', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'in:preferential,regular'],
            'contactName' => ['required', 'string', 'max:255'],
            'contactEmail' => ['required', 'email', 'max:255'],
            'offerPercentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'tradeName.required' => 'El nombre comercial es obligatorio.',
            'taxId.required' => 'El documento fiscal es obligatorio.',
            'category.required' => 'La categoría es obligatoria.',
            'category.in' => 'La categoría no es válida.',
            'contactName.required' => 'El nombre de contacto es obligatorio.',
            'contactEmail.required' => 'El correo de contacto es obligatorio.',
            'contactEmail.email' => 'El correo de contacto no es válido.',
            'offerPercentage.numeric' => 'El porcentaje de oferta debe ser un número.',
            'offerPercentage.min' => 'El porcentaje de oferta no puede ser menor que 0.',
            'offerPercentage.max' => 'El porcentaje de oferta no puede ser mayor que 100.',
        ];
    }
}
