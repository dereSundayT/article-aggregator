<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPreferenceRequest;
use App\Http\Service\UserService;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public ?Authenticatable $user;
    public function __construct(protected UserService $userService)
    {
        $this->user = auth()->user();
    }

    //
    public function getUserSettings(): JsonResponse
    {
        try{
            $userPreferences = $this->userService->getUserPreferenceService($this->user);
            return successResponse('User settings retrieved successfully', $userPreferences);
        }
        catch (\Throwable $throwable){
            storeErrorLog($throwable, 'User Preference Store Failed: ');
            return errorResponse('Something went wrong', null, 500);
        }

    }


    /**
     *
     */
    public function updateUserPreference(UpdateUserPreferenceRequest $request): JsonResponse
    {
       try{
           $user = $this->user;
           //Update user preferences
           $this->userService->updateUserPreferenceService($user, $request->categories, $request->authors,$request->sources);
           //Get updated user preferences
           $userPreferences = $this->userService->getUserPreferenceService($user);
           //Return response
           return successResponse('User settings updated successfully', $userPreferences);
       }
       catch (\Throwable $throwable){
           //Log error
           storeErrorLog($throwable, 'User Preference Update Failed: ');
           //Return error response
           return errorResponse('Something went wrong', null, 500);
       }
    }


    //
}
