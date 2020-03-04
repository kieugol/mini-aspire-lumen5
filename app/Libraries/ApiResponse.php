<?php

namespace App\Libraries;

use Illuminate\Http\Response;

/**
 * Class Api
 * @package App\Libraries
 */
trait ApiResponse
{
    public static function sendResponse($result = null, $statusCode = Response::HTTP_OK)
    {
        $dataReturn = [
            CODE_KEY    => $result[CODE_KEY] ?? $statusCode,
            MESSAGE_KEY => $result[MESSAGE_KEY] ?? '',
            DATA_KEY    => $result[DATA_KEY] ?? null,
        ];
        
        return response()->json($dataReturn, $statusCode);
    }
}
