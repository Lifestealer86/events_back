<?php

namespace App\Http\Resources;

use App\Models\Peoples;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'birth_date' => date('d-m-Y', strtotime($this->birth_date)),
            'sex' => $this->sex,
            'photo' => $this->photo,
            'peoples' => $this->usePeoples($this->id)
        ];
    }

    private function usePeoples($id): array
    {
        return Peoples::where(["user_id" => $id])->get(['id', 'first_name', 'last_name', 'date', 'sex'])->toArray();
    }
}
