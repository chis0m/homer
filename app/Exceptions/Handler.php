<?php

namespace App\Exceptions;

use App\Traits\TResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use TResponse;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
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
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return $this->error(null, 'Route Not Found', $exception->getStatusCode());
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->error(null, $exception->getMessage(), $exception->getStatusCode());
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this
                ->error(null, 'Resource for '.str_replace('App\\', '', $exception->getModel()).' not found', 500)
            ;
        }

        if ($exception instanceof UnauthorizedHttpException) {
            $preException = $exception->getPrevious();
            if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->error(null, 'UNAUTHENTICATED, TOKEN_EXPIRED', 401);
            }
            if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->error(null, 'UNAUTHENTICATED, TOKEN_INVALID', 401);
                // @phpstan-ignore-next-line
            }
            if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                return $this->error(null, 'UNAUTHENTICATED, TOKEN_BLACKLISTED', 401);
            }
            if ('Token not provided' === $exception->getMessage()) {
                return $this->error(null, 'UNAUTHENTICATED, TOKEN_NOT_PROVIDED', 401);
            }
        }

        return parent::render($request, $exception);
    }
}
