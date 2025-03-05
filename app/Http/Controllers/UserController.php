<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\ApiValidateException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function registration(RegistrationRequest $request): array
    {
        $res = $request->validated();
        $res['photo'] = $request->validated('photo')->store('storage/img/users', 'public');
        User::create($res);
        return [
            "data" => [
                'user' => [
                    "name" => $request->input("first_name"),
                    "email" => $request->input("email"),
                ],
            "code" => 201,
            "message" => "User created"
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

    public function showData($id): JsonResponse
    {
        $userResource = UserResource::collection(User::where(["id" => $id])->get());
        return response()->json(["data" => ["code" => 200, "body" => $userResource]]);
    }

    public function patchUser($id, ApiRequest $request): JsonResponse|ApiValidateException
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(["message" => "User not found"], 404);
        }
        if (Auth::id() != $id) {
            throw new ApiValidateException(403, false, "Forbidden", ["error" => "You are not allowed to modify this user"]);
        }
        $data = $request->validate([
            "first_name" => "required|string",
            "last_name" => "required|string",
            "password" => "required|string",
            "email" => "sometimes|email|unique:users,email,".$id
        ]);
        User::where(["id" => $request->id])->update($data);
        return response()->json([
            "data" => [
                "code" => 200,
                "message" => "User updated successfully"
            ]
        ]);
    }
}
