<?php

namespace App\Http\Resources;

use App\Models\EventPlace;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = Auth::user();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'event_counter' => $this->event_counter,
            'description' => $this->description,
            'img' => $this->img,
            'raiting' => $this->raiting,
            'start_date' => date('d.m.Y H:i', strtotime($this->start_date)),
            'end_date' => date('d.m.Y H:i', strtotime($this->end_date)),
            'event_place' => $this->withRequestToEventPlaceResource($this->event_place_id),
            'owner' => $this->user_id == $user->id
        ];
    }

    public function withRequestToEventPlaceResource($event_place_id):array
    {
        $result = EventPlace::where(["id" => $event_place_id])->first();
        $result['office'] = ($result['office'] == 0 || $result['office'] == "") ? '' : ', строение ' . $result['office'];
        $result['full_address'] = 'г. ' . $result['city'] . ', ул. ' . $result['street'] .
        ', д. ' . $result['house_number'] . $result['office'];
        return [$result['name'], $result['full_address']];
    }
}
