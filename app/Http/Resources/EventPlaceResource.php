<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class EventPlaceResource extends JsonResource
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
            'city' => $this->city,
            'street' => $this->street,
            'house_number' => $this->house_number,
            'office' => ($this->office == 0) ? "none" : $this->office,
            'owner' => $this->user_id == $user->id
        ];
    }
}
