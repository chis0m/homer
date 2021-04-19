<?php

namespace App\Http\Controllers\API\User\Auth;

use App\Http\Controllers\API\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\Register;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\Login;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\User;

/**
 * Class AuthController
 * @package App\Http\Controllers\API\User\Auth
 */
class AuthController extends Controller
{
    /**
     * @param Register $request
     * @return JsonResponse
     */
    public function register(Register $request): JsonResponse
    {
        $credentials = [
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ];
        $user = User::create($credentials);
        // @phpstan-ignore-next-line
        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    /**
     * @param Login $request
     * @return JsonResponse
     */
    public function login(Login $request): JsonResponse
    {
        if (! $token = auth()->attempt($request->only('email', 'password'))) {
            return $this->error(null, 'Invalid credentials', Response::HTTP_PRECONDITION_FAILED);
        }

        return $this->respondWithToken($token, Response::HTTP_OK);
    }


    /**
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return $this->success(auth()->user());
    }
}
