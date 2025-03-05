<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiValidateException;
use App\Http\Requests\ApiRequest;
use App\Http\Resources\BookEventResource;
use App\Models\BookEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class BookEventController extends Controller
{
    public function showBookEvent(): JsonResponse
    {
        $res = BookEventResource::collection(BookEvent::where(["user_id" => Auth::id()])->get());
        return response()->json(["data" => $res]);
    }

    public function storeBookEvent(ApiRequest $request): JsonResponse
    {
        $user = Auth::user();
        $res = $request->validate([
            'event_id' => 'required|integer',
        ]);
        $res["user_id"] = Auth::id();
        if (BookEvent::where(["user_id" => Auth::id(), "event_id" => $res["event_id"]])->count() == 1) {
            throw new ApiValidateException(401, false, "Mistake", ["message" => "only one booking is allowed"]);
        }
        $res["people_count"] = $user->people()->count();
        BookEvent::create($res);
        BookEvent::calculateAllPeopleCount();
        return response()->json(["data" => ["code" => 201, "message" => "Book Event created"]]);
    }

    public function deleteBookEvent($id): JsonResponse
    {
        if(BookEvent::where(["id" => $id])->count() == 0) {
            return response()->json(["data" => ["message" => "not found"]], 404);
        }
        else if (BookEvent::where(["user_id" => Auth::id(), "event_id" => $id])->count() == 0) {
            throw new ApiValidateException(403, false, "Forbidden", ["Forbidden event" => "you are not allowed to this person"]);
        }
        else if(BookEvent::where(["user_id" => Auth::id(), "event_id" => $id])->delete()) {
            BookEvent::calculatePeopleCount(Auth::id());
            return response()->json(["data" => [
                "message" => "deleted ".$id
            ]], 200);
        }
        return response()->json(["data" => ["message" => "Delete failed"]], 400);
    }
}
