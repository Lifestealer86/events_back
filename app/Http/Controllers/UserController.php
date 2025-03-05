<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\UserPatchRequest;
use App\Http\Resources\UserResource;
use App\Models\BookEvent;
use App\Models\Peoples;
use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\ApiValidateException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
                    "birth_date" => date("d-m-Y", strtotime($user->birth_date)),
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
        // BookEvent::calculateAllPeopleCount();
        $userResource = UserResource::collection(User::where(["id" => $id])->get());
        return response()->json(["data" => ["code" => 200, "body" => $userResource]]);
    }

    public function patchUser($id, UserPatchRequest $request): JsonResponse|ApiValidateException
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(["message" => "User not found"], 404);
        }
        if (Auth::id() != $id) {
            throw new ApiValidateException(403, false, "Forbidden", ["error" => "You are not allowed to modify this user"]);
        }
        $data = $request->validated();
        User::where(["id" => $request->id])->update($data);
        return response()->json([
            "data" => [
                "code" => 200,
                "message" => "User updated successfully"
            ]
        ]);
    }

    public function addPeoples(ApiRequest $request): JsonResponse|ApiValidateException
    {
        $user = Auth::user();
        $validated = $request->validate([
            'peoples' => ['required', 'array',
                function ($attribute, $value) use ($user) {
                    $existingCount = $user->people()->count();
                    $newCount = count($value);

                    if ($existingCount + $newCount > 5) {
                        $availableSlots = 5 - $existingCount;
                        throw new ApiValidateException(417, false, "Maximum peoples limit", ["Advice" => "Maximum 5 peoples. Available {$availableSlots}"]);
                    }
                },
            ],
            'peoples.*.first_name' => [
                'required',
                'string',
                'regex:/^[А-Я]{1}+[А-яЁё -]+$/u'
            ],
            'peoples.*.last_name' => [
                'required',
                'string',
                'regex:/^[А-Я]{1}+[А-яЁё -]+$/u'
            ],
            'peoples.*.date' => [
                'required',
                'date_format:d-m-Y'
            ],
            'peoples.*.sex' => [
                'required',
                'string',
                Rule::in(['мужской', 'женский'])
            ]
        ]);
        foreach ($validated['peoples'] as $peopleData) {
            $peopleData['user_id'] = Auth::id();
            $peopleData["date"] = date("Y-m-d", strtotime($peopleData["date"]));
            Peoples::create($peopleData);
        }
        BookEvent::calculatePeopleCount(Auth::id());
        return response()->json(["data" => ["code" => 201, "message" => "Peoples was added"]], 201);
    }

    public function deletePeople($id): JsonResponse
    {
        if(Peoples::where(["id" => $id])->count() == 0) {
            return response()->json(["data" => ["message" => "not found"]], 404);
        }
        else if (Peoples::where(["user_id" => Auth::id(), "id" => $id])->count() == 0) {
            throw new ApiValidateException(403, false, "Forbidden", ["Forbidden event" => "you are not allowed to this person"]);
        }
        else if(Peoples::where(["user_id" => Auth::id(), "id" => $id])->delete()) {
            BookEvent::calculatePeopleCount(Auth::id());
            return response()->json(["data" => [
                "message" => "deleted ".$id
            ]], 200);
        }
        return response()->json(["data" => ["message" => "Delete failed"]], 400);
    }
}
