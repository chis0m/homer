<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\Register;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\Login;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Traits\TResponder;
use App\Models\User;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    use TResponder;

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
        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ];

        return $this->success($data, 'Successful', Response::HTTP_CREATED);
    }

    /**
     * @param Login $request
     * @return JsonResponse
     */
    public function login(Login $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error(null, 'Invalid credentials', Response::HTTP_PRECONDITION_FAILED);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ];

        return $this->success($data, 'Successful', Response::HTTP_CREATED);
    }
}
