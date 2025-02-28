<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'regex:/^[А-Я]{1}+[А-яЁё -]+$/u'],
            'last_name' => ['required', 'string', 'regex:/^[А-Я]{1}+[А-яЁё -]+$/u'],
            'email' => ['required', 'unique:users', 'regex:/^[A-z]{1}+[\w.]+@+[\w]+.+[A-z]{2,5}+$/i'],
            'password' => ['required', Password::min(5)->mixedCase()->numbers()],
            'birth_date' => ['required', 'string', 'date_format:d-m-Y'],
            'sex' => ['required', 'string', Rule::in(['мужской', 'женский'])],
            'photo' => ['required', 'mimes:jpeg,jpg,png'],
        ];
    }
}

