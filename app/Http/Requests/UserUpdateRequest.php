<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'id' => ['required', 'exists:users,id'],
            'name' => ['required', 'max:30','regex:/^[а-яА-ЯёЁa-zA-Z\s]+$/u'],
            'surname' => ['required', 'max:30', 'regex:/^[а-яА-ЯёЁa-zA-Z]+$/u'],
            'patronymic' => ['required', 'max:30', 'regex:/^[а-яА-ЯёЁa-zA-Z]+$/u'],
            'phones' => ['required'],
            'phones.*.is_mobile' => ['required','integer', 'between:0,1'],
            'phones.*.number' => ['required',
                'integer',
                'between:1000000000,999999999999',
                Rule::unique('phones')->ignore($this->get('id'), 'user_id')],

        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $jsonResponse = response()->json(['errors' => $validator->errors()], 422);

        throw new HttpResponseException($jsonResponse);
    }

    public function messages()
    {
        return [
        ];
    }
}
