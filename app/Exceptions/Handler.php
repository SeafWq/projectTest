<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // Проверяем, является ли запрос API
        if ($request->expectsJson()) {
            if ($exception instanceof TokenInvalidException) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token is invalid.'
                ], 401);
            }

            if ($exception instanceof TokenExpiredException) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token has expired.'
                ], 401);
            }

            if ($exception instanceof JWTException) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token is absent or malformed.'
                ], 401);
            }

            if ($exception instanceof UnauthorizedHttpException) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized. Please provide a valid token.'
                ], 401);
            }

            if ($exception instanceof AuthenticationException) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized. Please log in to access this resource.'
                ], 401);
            }
        }

        return parent::render($request, $exception);
    }
}
