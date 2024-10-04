<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VehicleRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $errors
        ], 422));
    }

    public function rules(): array
    {
        $vehichleId = $this->route('vehicle') ? $this->route('vehicle')->id : null;
        return [
            'type' => 'required|string',
            'manufacturer' => 'required|string',
            'manufacture_year' => 'integer|nullable',
            'model' => 'required|string',
            'model_year' => 'integer|nullable',
            'fuel_type' => 'string|nullable',
            'steering_type' => 'string|nullable',
            'transmission' => 'string|nullable',
            'doors' => 'integer',
            'license_plate' => 'nullable|string|unique:vehicles,license_plate,' . $vehichleId,
            'color' => 'string|nullable',
            'price' => 'required|numeric',
            'description' => 'string|nullable',
            'current_km' => 'integer|nullable',
            'is_new' => 'boolean',
            'is_featured' => 'boolean',
            'renavam' => 'nullable|string',
            'store_id' => 'required|exists:stores,id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Este campo é obrigatório',
            'type.string' => 'O campo tipo deve ser uma string',
            'manufacturer.string' => 'O campo fabricante deve ser uma string',
            'manufacturer_year.integer' => 'O campo ano de fabricação deve ser um número inteiro',
            'brand.string' => 'O campo marca deve ser uma string',
            'model.string' => 'O campo modelo deve ser uma string',
            'model_year.integer' => 'O campo ano do modelo deve ser um número inteiro',
            'fuel_type.string' => 'O campo tipo de combustível deve ser uma string',
            'steering_type.string' => 'O campo tipo de direção deve ser uma string',
            'transmission.string' => 'O campo transmissão deve ser uma string',
            'doors.integer' => 'O campo portas deve ser um número inteiro',
            'year.integer' => 'O campo ano deve ser um número inteiro',
            'license_plate.string' => 'O campo placa deve ser uma string',
            'license_plate.unique' => 'A placa informada já está em uso',
            'color.string' => 'O campo cor deve ser uma string',
            'mileage.integer' => 'O campo quilometragem deve ser um número inteiro',
            'price.numeric' => 'O campo preço deve ser um número',
            'description.string' => 'O campo descrição deve ser uma string',
            'current_km.integer' => 'O campo quilometragem atual deve ser um número inteiro',
            'is_new.boolean' => 'O campo deve ser um booleano',
            'is_featured.boolean' => 'O campo deve ser um booleano',
            'renavam.string' => 'O campo renavam deve ser uma string',
            ];
    }
}
