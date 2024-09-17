<?php

namespace App\Exceptions;

use App\Http\Responses\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            // Customize the JSON response for unauthenticated users
            return ApiResponse::error('You should login first', 401, 'Unauthenticated');
        }
    }
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return ApiResponse::error('Resource not found', 404, 'Not found');
        }
        if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            // Customize the error response for authorization exceptions
            if ($request->wantsJson()) {
                return ApiResponse::error('You are not authorized to perform this action', 401, 'Unauthorized');
            }
        }

        return parent::render($request, $exception);
    }
}
