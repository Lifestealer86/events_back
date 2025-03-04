<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiValidateException;
use App\Http\Requests\ApiRequest;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\EventPlace;
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
        $res['start_date'] = $this->checkTime($res['start_date']);
        $res['end_date'] = $this->checkTime($res['end_date']);
        $res['user_id'] = $user->id;
        Event::create($res);
        return response()->json(["data" => ["message" => "created " . $res["name"]]]);
    }

    public function patchEvent(EventRequest $request): JsonResponse|ApiValidateException
    {
        $data = $request->validated();
        if (Event::where(["id" => $request->id])->count() == 0) {
            return response()->json(["data" => ["message" => "not found Event"]], 404);
        } else if (Event::where(["user_id" => Auth::id(), "id" => $request->id])->count() == 0) {
            throw new ApiValidateException(403, false, "Forbidden", ["Forbidden event" => "you are not allowed to change this event"]);
        }
        $data['start_date'] = $this->checkTime($data['start_date']);
        $data['end_date'] = $this->checkTime($data['end_date']);
        Event::where(["id" => $request->id])->update($data);
        return response()->json(["data" => ["message" => "change " . $data["name"]]]);
    }

    public function delete($id): JsonResponse
    {
        if(Event::where(["id" => $id])->count() == 0) {
            return response()->json(["data" => ["message" => "not found"]], 404);
        }
        else if (Event::where(["user_id" => Auth::id(), "id" => $id])->count() == 0) {
            throw new ApiValidateException(403, false, "Forbidden", ["Forbidden event" => "you are not allowed to this event"]);
        }
        else if(Event::where(["user_id" => Auth::id(), "id" => $id])->delete()) return response()->json(["data" => [
            "message" => "deleted ".$id
        ]], 200);
        return response()->json(["data" => ["message" => "Delete failed"]], 400);
    }

    public function search($query): JsonResponse
    {
        $query = explode("=", strtolower(trim($query)));
        $events = Event::where('name', 'LIKE', "%$query[1]%")->get(['id', 'name', 'description', 'start_date', 'end_date', 'img']);
        $events_places = EventPlace::where('name', 'LIKE', "%$query[1]%")->get(['id', 'name', 'city', 'street']);
        return response()->json(["events" => [$events], "event_places" => [$events_places]]);
    }
    public function checkTime($date_field): string
    {
        $time = date("H:i", strtotime($date_field));
        if($time < "09:00" || $time > "21:00") {
            throw New ApiValidateException(422, false, "Validation error",
                ["time" => "Time must be after 09:00 hours and before 21:00 hours"]);
        } else {
            return date("Y-m-d H:i", strtotime($date_field));
        }
    }
}
