<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;

class ApiException extends HttpResponseException
{
    public function __construct(string $message = '', int $code = 500, $errors = [], $data = [])
    {
        $body = [
            'code' => $code,
            'message' => $message,
        ];
        if (count($errors))
            $body['errors'] = $errors;

        if ($data)
            array_push($body, ...$data);

        parent::__construct(response($body, $code));
    }
}
