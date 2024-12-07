<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Service\AuthenticationService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthenticationApiController extends Controller
{

    public function __construct(protected AuthenticationService $authenticationService)
    {
    }

    /**
     * @description: This function is used to register a new user
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->authenticationService->userRegistrationService($request->name, $request->email, $request->password);
            Log::error("Error",[
                'user' => $user
            ]);
            if ($user) {
                return successResponse('User created successfully', null, 201);
            }

            return errorResponse('User registration failed', null);

        } catch (Throwable $th) {
            storeErrorLog($th, 'User Registration Failed: ');
            return errorResponse('Something went wrong', null, 500);
        }
    }


    /**
     *
     * @description: This function is used to log in a user
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $userLoginDetails = $this->authenticationService->userLoginService($request->email, $request->password);

            if ($userLoginDetails) {
                return successResponse('Login successful', $userLoginDetails);
            }

            return errorResponse('Invalid credentials', null);

        } catch (Throwable $th) {
            storeErrorLog($th, 'User Login Failed');
            return errorResponse('Something went wrong', null, 500);
        }
    }


}
