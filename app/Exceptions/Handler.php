<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\QueryException;
use ErrorException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use App\Libraries\ApiResponse;
use App\Helpers\CommonHelper;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    use ApiResponse;
    use CommonHelper;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // Customize response correspond to some below exception
        
        if ($e instanceof ValidationException && $e->getResponse()) {
            $errors = json_decode($e->getResponse()->getContent(), true);

            return $this->sendResponse([MESSAGE_KEY => $this->formatErrorsMessage($errors)], Response::HTTP_BAD_REQUEST);
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->sendResponse([MESSAGE_KEY => trans('message.page_not_found')], Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof HttpException) {
            return $this->sendResponse([MESSAGE_KEY => $e->getMessage()], $e->getStatusCode());
        }
    
        if ($e instanceof QueryException) {
            Log::error("{$e->getMessage()} At {$e->getFile()} ({$e->getLine()})");
            Log::error($e->getSql());
            return $this->sendResponse([MESSAGE_KEY => trans('message.server_error')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        if ($e instanceof ErrorException) {
            Log::error("{$e->getMessage()} At {$e->getFile()} ({$e->getLine()})");
            return $this->sendResponse([MESSAGE_KEY => trans('message.server_error')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return parent::render($request, $e);
    }
}
