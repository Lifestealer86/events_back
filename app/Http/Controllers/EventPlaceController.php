<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventPlaceRequest;
use App\Models\EventPlace;
use App\Http\Resources\EventPlaceResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class EventPlaceController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json(["data" => EventPlaceResource::collection(EventPlace::all())]);
    }

    public function store(EventPlaceRequest $request): JsonResponse
    {
        $user = Auth::user();
        $res = $request->validated();
        $res['user_id'] = $user->id;
        EventPlace::create($res);
        return response()->json(["data" => ["message" => "created ".$res["name"]]]);
    }

    public function delete($id): JsonResponse
    {
        if(EventPlace::where(["id" => $id])->count() == 0) {
            return response()->json(["data" => ["message" => "not found"]], 404);
        }
        else if (EventPlace::where(["user_id" => Auth::id(), "id" => $id])->count() == 0) {
            return response()->json(["data" => ["message" => "you are not allowed to delete this place"]], 403);
        }
        else if(EventPlace::where(["user_id" => Auth::id(), "id" => $id])->delete()) return response()->json(["data" => [
            "message" => "deleted ".$id
        ]], 200);
        return response()->json(["data" => ["message" => "Delete failed"]], 400);
    }
}
