<?php

namespace App\Modules\Auth\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserParentValidate extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'city_id' => 'required|integer',
            'relation_id' => 'required|integer',
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'job_place' => 'required|string',
            'position' => 'required|string',
            'birthday' => 'required|string',
            'iin' => 'required|array',
            'mobile' => 'required|string|unique:users',
            'save_interface' => 'required|string',
            'street' => 'required|string',
            'house_number' => 'required|integer',
            'apt' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'relation_id.required' => __('User::messages.required'),
            'lastname.required' => __('User::messages.required'),
            'firstname.required' => __('User::messages.required'),
            'job_place.required' => __('User::messages.required'),
            'position.required' => __('User::messages.required'),
            'birthday.required' => __('User::messages.required'),
            'iin.*.required' => __('User::messages.required'),
            'mobile.required' => __('User::messages.required'),
            'fast_code.required' => __('User::messages.required'),
            'save_interface.required' => __('User::messages.required'),
            'roles.*.required' => __('User::messages.required'),
            'city_id.required' => __('User::messages.required'),
            'school_id.required' => __('User::messages.required'),
            'class.required' => __('User::messages.required'),
            'letter.required' => __('User::messages.required'),
            'gender_id.required' => __('User::messages.required'),
            'subjects.*.required' => __('User::messages.required'),
        ];
    }

    public function attributes()
    {
        return [
            'relation_id' => __('Badge::main.relation_id'),
            'lastname' => __('Badge::main.lastname'),
            'firstname' => __('Badge::main.firstname'),
            'job_place' => __('Badge::main.job_place'),
            'position' => __('Badge::main.position'),
            'birthday' => __('Badge::main.birthday'),
            'iin' => __('Badge::main.iin'),
            'mobile' => __('Badge::main.mobile'),
            'fast_code' => __('Badge::main.fast_code'),
            'save_interface' => __('Badge::main.save_interface'),
            'roles' => __('Badge::main.roles'),
            'city_id' => __('Badge::main.city_id'),
            'school_id' => __('Badge::main.school_id'),
            'class' => __('Badge::main.class'),
            'letter' => __('Badge::main.letter'),
            'gender_id' => __('Badge::main.gender_id'),
            'subjects' => __('Badge::main.subjects'),
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
