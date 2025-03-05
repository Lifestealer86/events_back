<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbacksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->useUser($this->user_id),
            'text' => $this->text,
            'img_raiting' => $this->img_raiting,
            'raiting' => $this->raiting
        ];
    }

    public function useUser($user_id):array
    {
        return User::where(["id" => $user_id])->first(['first_name', 'last_name','photo'])->toArray();
    }
}
