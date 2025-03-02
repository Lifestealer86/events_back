<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json([
            "data" => EventResource::collection(Event::all())
        ]);
    }

    public function showOne($id): JsonResponse
    {
        return response()->json([
            "data" => new EventResource(Event::findOrFail($id))
        ]);
    }

    public function store(EventRequest $request): JsonResponse
    {
        $user = Auth::user();
        $res = $request->validated();
        $res['photo'] = $request->validated('img')->store('storage/img', 'public');
        $res['start_date'] = date("Y-m-d H:i", strtotime($res['start_date']));
        $res['end_date'] = date("Y-m-d H:i", strtotime($res['end_date']));
        $res['user_id'] = $user->id;
        Event::create($res);
        return response()->json(["data" => ["message" => "created " . $res["name"]]]);
    }

    public function patchEvent(EventRequest $request): JsonResponse
    {
        $data = $request->validated();
        if (Event::where(["id" => $request->id])->count() == 0) {
            return response()->json(["data" => ["message" => "not found"]], 404);
        } else if (Event::where(["user_id" => Auth::id(), "id" => $request->id])->count() == 0) {
            return response()->json(["data" => ["message" => "you are not allowed to change this event"]], 403);
        }
        if($data['start_date']) $data['start_date'] = date("Y-m-d H:i", strtotime($data['start_date']));
        if($data['end_date']) $data['end_date'] = date("Y-m-d H:i", strtotime($data['start_date']));
        Event::where(["id" => $request->id])->update($data);
        return response()->json(["data" => ["message" => "change " . $data["name"]]]);
    }
}
