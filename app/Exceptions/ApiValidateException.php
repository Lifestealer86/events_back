<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;

class ApiValidateException extends HttpResponseException
{
    public function __construct($code = 422, $success = false, $message = 'Validation error', $errors = [])
    {
        $data = [
            "error" => [
                'code' => $code,
                'message' => $message,
                'errors' => $errors
            ]
        ];

        if (count($errors) > 0) {
            $data["error"]['errors'] = $errors;
        }
        parent::__construct(response()->json($data)->setStatusCode($code, $message));
    }

}
