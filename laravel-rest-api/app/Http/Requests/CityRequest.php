<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->method() == 'PATCH'){
            return [
            'zip_code' => 'nullable|integer|between:1000,9999',
            'city' => 'nullable|string|min:3|max:50',
            'id_county' => 'nullable|integer',
            'population' => 'nullable|integer',
            ];
        }

        return [
            'zip_code' => 'required|integer|between:1000,9999',
            'city' => 'required|string|min:3|max:50',
            'id_county' => 'required|integer',
            'population' => 'required|integer',
        ];
    }
}
