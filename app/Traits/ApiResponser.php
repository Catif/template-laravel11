<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponser
{
  const DEFAULT_MESSAGE = [
    // Success
    200 => 'Success',
    201 => 'Created',
    204 => 'No Content',

    // Error
    400 => 'Bad Request',
    401 => 'Unauthorized',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    422 => 'Unprocessable Entity',
    500 => 'Internal Server Error',
  ];

  protected function success($data = [], $message = null, $code = 200): JsonResponse
  {
    $response = [
      'data' => $data,
      'meta' => [
        'success' => true,
        'message' => $message ?? self::DEFAULT_MESSAGE[$code],
      ],
    ];

    return response()->json($response, $code);
  }

  protected function error($message = "Not Found", $code = 404): JsonResponse
  {
    $response = [
      'data' => [
        'message' => $message,
        'code' => $code,
      ],
      'meta' => [
        'success' => false,
        'message' => self::DEFAULT_MESSAGE[$code],
      ]
    ];

    return response()->json($response, $code);
  }
}
