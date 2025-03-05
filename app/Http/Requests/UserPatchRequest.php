<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserPatchRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'first_name' => ['required', 'string', 'regex:/^[А-Я]{1}+[А-яЁё -]+$/u'],
            'last_name' => ['required', 'string', 'regex:/^[А-Я]{1}+[А-яЁё -]+$/u'],
            'email' => ["sometimes", "email", "unique:users,email,{$id}", 'regex:/^[A-z]{1}+[\w.]+@+[\w]+.+[A-z]{2,5}+$/i'],
            'password' => ['required', Password::min(5)->mixedCase()->numbers()]
        ];
    }
}

