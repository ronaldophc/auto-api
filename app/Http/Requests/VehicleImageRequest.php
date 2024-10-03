<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VehicleImageRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $validator->errors()
        ], 422));
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => 'required|exists:vehicles,id',
            'is_cover' => 'boolean|nullable',
        ];
    }

    public function messages()
    {
        return [
            'vehicle_id.required' => 'O campo veículo é obrigatório',
            'vehicle_id.exists' => 'Veículo não encontrado',
            'is_cover.boolean' => 'O campo capa deve ser um booleano',
        ];
    }
}
