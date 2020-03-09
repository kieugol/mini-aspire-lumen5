<?php

namespace App\Libraries;

use Illuminate\Http\Response;

/**
 * Class Api
 * @package App\Libraries
 */
trait ApiResponse
{
    /**
     * Send response data to client
     *
     * @param array $result
     * @param int  $statusCode
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendResponse(array $result, $statusCode = Response::HTTP_OK)
    {
        $body = [
            CODE_KEY    => $result[CODE_KEY] ?? $statusCode,
            MESSAGE_KEY => $result[MESSAGE_KEY] ?? '',
            DATA_KEY    => $result[DATA_KEY] ?? null,
        ];
        
        return response()->json($body, $statusCode);
    }
}
