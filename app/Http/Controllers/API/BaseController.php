<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{


    public function jsonResponse(mixed $result, string $message, int $code = 200)
{
    if (is_array($result) || $result instanceof \Illuminate\Contracts\Support\Arrayable) {
        $result = (object) $result;
    }

    if ($result instanceof \stdClass || is_object($result)) {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
    } else {
        return $this->jsonResponseError('Invalid result format', 500);
    }

    return response()->json($response, $code);
}

public function jsonResponseError(string $errorMessage, int $code = 500, $data = [])
{
    $response = [
        'success' => false,
        'message' => $errorMessage,
        'data'    => $data,
    ];

    return response()->json($response, $code);
}



}
