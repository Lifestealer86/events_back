<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiValidateException;
use App\Http\Requests\ApiRequest;
use App\Http\Requests\FeedbackRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\FeedbacksResource;
use App\Models\Event;
use App\Models\Feedbacks;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FeedbacksController extends Controller
{
    public function showFeedbacks($id, ApiRequest $request): JsonResponse
    {
        $feedbacksResource = FeedbacksResource::collection(Feedbacks::where(["event_id" => $id])->get());
//        foreach (EventResource::collection(Event::all()) as $event) {
//            Feedbacks::calculateRaiting($event->id);
//        }
        return response()->json([
            "data" => $feedbacksResource->toArray($request)
        ]);
    }

    public function storeFeedback($id, FeedbackRequest $request): JsonResponse
    {
        $res = $request->validated();
        $res['img_raiting'] = $request->validated('img_raiting')->store('storage/img/feedbacks', 'public');
        $res['user_id'] = Auth::id();
        $res["event_id"] = $id;
        if (Feedbacks::where(["user_id" => Auth::id(), "event_id" => $id])->count() == 1) {
            throw new ApiValidateException(401, false, "Mistake", ["message" => "only one feedback is allowed"]);
        }
        Feedbacks::calculateRaiting($id, $res['raiting']);
        Feedbacks::create($res);
        return response()->json([
            "data" => ["code" => 201, "message" => "Feedback saved successfully"]
        ]);
    }

    public function deleteFeedback($id): JsonResponse
    {
        if(Feedbacks::where(["event_id" => $id])->count() == 0) {
            return response()->json(["data" => ["message" => "not found"]], 404);
        }
        else if (Feedbacks::where(["user_id" => Auth::id(), "event_id" => $id])->count() == 0) {
            throw new ApiValidateException(403, false, "Forbidden", ["Forbidden event" => "you are not allowed to this event"]);
        }
        else if(Feedbacks::where(["user_id" => Auth::id(), "event_id" => $id])->delete()) {
            Feedbacks::calculateRaiting($id);
            return response()->json(["data" => [
                "message" => "deleted ".$id
            ]], 200);
        }
        return response()->json(["data" => ["message" => "Delete failed"]], 400);
    }
}
