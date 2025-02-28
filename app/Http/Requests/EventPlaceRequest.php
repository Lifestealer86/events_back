<?php

namespace App\Http\Requests;

class EventPlaceRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'city' => 'required|string',
            'street' => 'required|string',
            'house_number' => 'required|string',
            'office' => 'string'
        ];
    }
}
