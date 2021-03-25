<?php

namespace App\Traits;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * @trait TResponse
 *  T stands for trait
 */
trait TResponse
{
    /**
     * success.
     *
     * @param mixed $data
     * @param mixed $message
     * @param mixed $statusCode
     */
    public function success($data = [], string $message = 'Successful', int $statusCode = Response::HTTP_OK): Response
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * error.
     *
     * @param mixed $data
     * @param mixed $message
     * @param mixed $statusCode
     */
    public function error(array $data = null, $message = 'Unsuccessful', $statusCode = Response::HTTP_BAD_REQUEST): Response
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $data,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * fatalError.
     *
     * @param mixed $e
     * @param mixed $statusCode
     */
    public function fatalError(Exception $e, int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): Response
    {
        $line = $e->getTrace();

        $error = [
            'message' => $e->getMessage(),
            'trace' => $line[0],
            'mini_trace' => $line[1],
        ];

        if ('PRODUCTION' === strtoupper(config('APP_ENV'))) {
            $error = null;
        }

        $response = [
            'success' => false,
            'message' => 'Oops! Something went wrong on the server',
            'errors' => $error,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * respond.
     *
     * @param mixed $e
     */
    public function respond(Exception $e): Response
    {
        $trace = [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'code' => $e->getCode(),
            'time' => \Carbon\Carbon::now()->toDayDateTimeString(),
        ];
        $code = ($e->getCode()) ? $e->getCode() : 500;
        if ($code < 500) {
            return $this->error(null, $e->getMessage(), $code);
        }

        return $this->fatalError($e);
    }
}
