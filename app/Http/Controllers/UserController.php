<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registration(RegistrationRequest $request): array
    {
        $res = $request->validated();
        $res['photo'] = $request->validated('photo')->store('storage/img', 'public');
        User::create($res);
        return [
            "data" => [
                'user' => [
                    "name" => $request->input("first_name"),
                    "email" => $request->input("email"),
                ],
            "code" => 201,
            "message" => "Пользователь создан"
            ]
        ];
    }
}
