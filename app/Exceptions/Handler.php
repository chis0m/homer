<?php

namespace App\Exceptions;

use Globals\Traits\TResponder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use TResponder;
    /**
     * A list of the exception types that are not reported.
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
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register() :void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    public function render($request, Throwable $e)
    {
        if ($e instanceof ApplicationExcepiton) {
            $code = $e->getCode();
            $message = $e->getMessage();
            return $this->error(null, $message, $code);
        }

            // If Model Not found (e.g: not existing user error)
        if ($e instanceof ModelNotFoundException) {
            $model = ucwords(strtolower(class_basename($e->getModel())));
            return $this->error(
                null,
                "Does not exist any instance of {$model} with the given id",
                Response::HTTP_NOT_FOUND
            );
        }

        // Handling the Unauthorized exception
        if ($e instanceof AuthorizationException) {
            return $this->error(null, $e->getMessage(), Response::HTTP_FORBIDDEN);
        }

        if ($e instanceof AuthenticationException) {
            return $this->error(null, $e->getMessage(), Response::HTTP_UNAUTHORIZED);
        }

        if ($e instanceof ValidationException) {
            $errors = $e->validator->errors()->getMessages();
            return $this->error($errors, 'invalid credentials', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($e instanceof UnauthorizedHttpException) {
            $preException = $e->getPrevious();
            if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->error(null, 'UNAUTHENTICATED, TOKEN_EXPIRED', 401);
            }

            if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->error(null, 'UNAUTHENTICATED, TOKEN_INVALID', 401);
            }

            if ($e->getMessage() === 'Token not provided') {
                return $this->error(null, 'UNAUTHENTICATED, TOKEN_NOT_PROVIDED', 401);
            }
        }

        if (env('APP_DEBUG', false)) {
            return parent::render($request, $e);
        }

        // @phpstan-ignore-next-line
        return $this->fatalError($e);
    }
}
