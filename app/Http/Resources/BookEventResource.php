<?php

namespace App\Http\Resources;

use App\Models\Event;
use App\Models\User;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user" => $this->useUser($this->user_id),
            "event" => $this->useEvent($this->event_id)
        ];
    }
    public function useUser($user_id): array
    {
        return User::where(["id" => $user_id])->first(['first_name', 'last_name','photo'])->toArray();
    }
    public function useEvent($event_id): array
    {
        $events = Event::where('id', $event_id)->get();
        return EventResource::collection($events)->toArray(request());
    }
}
