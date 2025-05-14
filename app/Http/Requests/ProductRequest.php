<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'string|required|max:100|min:7',
            'descripcion' => 'string|required|max:255|min:20',
            'talla' => 'string|required|max:4|min:1',
            'stock' => 'integer|required',
            'precio' => 'numeric|required',
            'categoria' => 'required|in:Club,Seleccion,Retro,Edicion Especial',
            'año' => 'string|required|size:4'
        ];
    }
}
