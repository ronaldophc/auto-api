<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
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
            'name' => 'required|string',
            'logo' => 'string|nullable',
            'address' => 'required|string',
            'phone' => 'required|string',
            'whatsapp' => 'required|string',
            'instagram' => 'string|nullable',
            'tiktok' => 'string|nullable',
            'facebook' => 'string|nullable',
            'google_maps' => 'string|nullable',
            'description' => 'string|nullable',
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'name.string' => 'O campo nome deve ser uma string',
            'logo.string' => 'O campo logo deve ser uma string',
            'address.required' => 'O campo endereço é obrigatório',
            'address.string' => 'O campo endereço deve ser uma string',
            'phone.required' => 'O campo telefone é obrigatório',
            'phone.string' => 'O campo telefone deve ser uma string',
            'whatsapp.required' => 'O campo whatsapp é obrigatório',
            'whatsapp.string' => 'O campo whatsapp deve ser uma string',
            'instagram.string' => 'O campo instagram deve ser uma string',
            'tiktok.string' => 'O campo tiktok deve ser uma string',
            'facebook.string' => 'O campo facebook deve ser uma string',
            'google_maps.string' => 'O campo google_maps deve ser uma string',
            'description.required' => 'O campo descrição é obrigatório',
            'description.string' => 'O campo descrição deve ser uma string',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'O campo email deve ser um email',
            'email.unique' => 'Email já cadastrado',
        ];
    }
}
