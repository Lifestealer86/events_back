<?php

namespace App\Http\Requests;

class EventRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => "string|required",
            'event_counter' => "integer|required",
            'description' => "string|required",
            'img' => ['image', 'mimes:jpeg,jpg,png'],
            'start_date' => 'required', 'string', 'date_format:d-m-Y H:i',
            'end_date' => 'required', 'string', 'date_format:d-m-Y H:i',
            'event_place_id' => "integer|required"
        ];
    }
}
