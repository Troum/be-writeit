<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    use ResponseTrait;
    /**
     * @param SignupRequest $request
     * @return JsonResponse
     */
    public function register(SignupRequest $request): JsonResponse
    {
        try {
            $user = new User();
            $user->register($request);
            $accessToken = $user->createToken('authToken')->accessToken;
            $response = [
                'user' => $user,
                '_token' => $accessToken
            ];
            return $this->successResponse($response, 'Successfully registered');
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials)) {
            return $this->errorResponse('Invalid credentials');
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $response = [
            'user' => [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email
            ],
            '_token' => $accessToken
        ];

        return $this->successResponse($response, 'Successfully logged in');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            return response()->json([
                'success' => 'You were successfully logged out'
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

}
