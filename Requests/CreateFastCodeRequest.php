<?php

namespace App\Modules\Auth\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateFastCodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mobile' => 'required',
            'code' => 'required',
            'tmp_token' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'mobile.required' => __('User::messages.mobile'),
            'code.required' => __('User::messages.code'),
            'tmp_token.required' => __('User::messages.tmp_token'),
        ];
    }

    public function attributes()
    {
        return [
            'mobile' => __('User::main.mobile'),
            'code' => __('User::main.code'),
            'tmp_token' => __('User::main.tmp_token')
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Запрос не прошел валидацию',
            'data'      => $validator->errors()
        ],400));
    }
}
