<?php

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Globals\Traits\TResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, TResponder;

    public function refresh(): JsonResponse
    {
        // @phpstan-ignore-next-line
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token, $statusCode = Response::HTTP_CREATED): JsonResponse
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            // @phpstan-ignore-next-line
            'expires_in' => Auth::guard()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ];
        // @phpstan-ignore-next-line
        return $this->success($data, 'Successful', $statusCode);
    }
}
