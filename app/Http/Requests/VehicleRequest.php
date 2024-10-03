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
            'type.required' => 'O campo tipo é obrigatório',
            'type.string' => 'O campo tipo deve ser uma string',
            'manufacturer.required' => 'O campo fabricante é obrigatório',
            'manufacturer.string' => 'O campo fabricante deve ser uma string',
            'manufacturer_year.required' => 'O campo ano de fabricação é obrigatório',
            'manufacturer_year.integer' => 'O campo ano de fabricação deve ser um número inteiro',
            'brand.required' => 'O campo marca é obrigatório',
            'brand.string' => 'O campo marca deve ser uma string',
            'model.required' => 'O campo modelo é obrigatório',
            'model.string' => 'O campo modelo deve ser uma string',
            'model_year.required' => 'O campo ano do modelo é obrigatório',
            'model_year.integer' => 'O campo ano do modelo deve ser um número inteiro',
            'fuel_type.required' => 'O campo tipo de combustível é obrigatório',
            'fuel_type.string' => 'O campo tipo de combustível deve ser uma string',
            'steering_type.required' => 'O campo tipo de direção é obrigatório',
            'steering_type.string' => 'O campo tipo de direção deve ser uma string',
            'transmission.required' => 'O campo transmissão é obrigatório',
            'transmission.string' => 'O campo transmissão deve ser uma string',
            'doors.required' => 'O campo portas é obrigatório',
            'doors.integer' => 'O campo portas deve ser um número inteiro',
            'year.required' => 'O campo ano é obrigatório',
            'year.integer' => 'O campo ano deve ser um número inteiro',
            'license_plate.string' => 'O campo placa deve ser uma string',
            'license_plate.unique' => 'A placa informada já está em uso',
            'color.required' => 'O campo cor é obrigatório',
            'color.string' => 'O campo cor deve ser uma string',
            'mileage.required' => 'O campo quilometragem é obrigatório',
            'mileage.integer' => 'O campo quilometragem deve ser um número inteiro',
            'price.required' => 'O campo preço é obrigatório',
            'price.numeric' => 'O campo preço deve ser um número',
            'description.string' => 'O campo descrição deve ser uma string',
            'current_km.required' => 'O campo quilometragem atual é obrigatório',
            'current_km.integer' => 'O campo quilometragem atual deve ser um número inteiro',
            'is_new.required' => 'O campo é novo é obrigatório',
            'is_new.boolean' => 'O campo é novo deve ser um booleano',
            'is_featured.required' => 'O campo é destaque é obrigatório',
            'is_featured.boolean' => 'O campo é destaque deve ser um booleano',
            'renavam.string' => 'O campo renavam deve ser uma string',
            'store_id.required' => 'O campo loja é obrigatório',
            ];
    }
}
