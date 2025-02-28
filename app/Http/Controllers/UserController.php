<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\ApiValidateException;
use Illuminate\Http\JsonResponse;

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

    public function authorization(Request $request): array
    {
        $user = User::where(['email' => $request->email])->first();
        if ($user and Hash::check($request->password, $user->password)) {
            return ["data" => [
                "user" => [
                    "id" => $user->id,
                    "name" => $user->first_name,
                    "birth_date" => date("d-m-Y",strtotime($user->birth_date)),
                    "email" => $user->email,
                ],
                "token" => $user->createToken(Str::random(5))->plainTextToken
            ]];
        }
        throw new ApiValidateException(401, false, "Login failed", ["email and password" => "Login failed"]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([], 204);
    }
}
