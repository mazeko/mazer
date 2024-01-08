<?php

namespace App\Exceptions;

use Throwable;
use App\Helpers\ResponseFormatter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

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
        
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpException) {
            return response()->json(ResponseFormatter::failed($exception->getStatusCode(), $exception->getMessage()), $exception->getStatusCode());
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json(ResponseFormatter::failed($exception->getCode(), $exception->getMessage()), $exception->getCode());
        }

        if ($exception instanceof ValidationException) {
            return response()->json(ResponseFormatter::failed($exception->status, VALIDATION_ERROR, $exception->validator->errors()->getMessages()), $exception->status);
        }

        return parent::render($request, $exception);
    }
}
