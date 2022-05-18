<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Str;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            $modelName = Str::lower(class_basename($exception->getModel()));

            return response([
                "message" => "Model not found.",
                "errors" => [
                    $modelName => [
                        "No {$modelName} found with the provided id."
                    ]
                ]
            ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response([
                "message" => "Invalid Url.",
                "errors" => [
                    "url" => [
                        "{$request->fullUrl()} is invalid."
                    ]
                ],
            ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response([
                "message" => "Method not allowed.",
                "errors" => [
                    "url" => [
                        "The {$request->method()} method is not supported for this route."
                    ]
                ],
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($exception instanceof AuthorizationException) {
            return response([
                "message" => "Not authorized.",
                "errors" => [
                    'user' => [
                        "{$exception->getMessage()}"
                    ]
                ],
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof AuthenticationException) {
            return response([
                "message" => "Not authenticated.",
                "errors" => [
                    'user' => [
                        "{$exception->getMessage()}"
                    ]
                ],
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof HttpException) {
            return response([
                "message" => "Invalid.",
                "errors" => [
                    'reason' => [
                        "{$exception->getMessage()}"
                    ]
                ],
            ], $exception->getStatusCode());
        }

        /**
         * If the exception is not one of the exceptions listed above 
         * ! IF -- The application is in DEBUG mode
         *      Display the Detailed ERROR
         * ! ELSE -- In all other cases, send the Internal Server Error
         */
        if (env('APP_DEBUG', false)) {
            return parent::render($request, $exception);
        }

        return response([
            "message" => "Internal server error.",
            "errors" => [
                'server' => [
                    "Please try again."
                ]
            ],
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
