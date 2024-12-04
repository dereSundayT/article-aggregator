<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPreferenceRequest;
use App\Http\Service\UserService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;

use Throwable;

class UserApiController extends Controller
{
    public ?Authenticatable $user;

    public function __construct(protected UserService $userService)
    {
        $this->user = auth()->user();
    }

    /**
     * @description Get user details
     * @return JsonResponse
     */
    public function getUser(): JsonResponse
    {
        try {
            return successResponse('User details retrieved successfully', $this->user);
        } catch (Throwable $throwable) {
            storeErrorLog($throwable, 'User Retrieval Failed: ');
            return errorResponse('Something went wrong', null, 500);
        }
    }


    /**
     * @description Get user settings preferences
     * @return JsonResponse
     */
    public function getUserSettings(): JsonResponse
    {
        try {
            $userPreferences = $this->userService->getUserPreferenceService($this->user);
            return successResponse('User settings retrieved successfully', $userPreferences);
        } catch (Throwable $throwable) {
            storeErrorLog($throwable, 'User Preference Store Failed: ');
            return errorResponse('Something went wrong', null, 500);
        }
    }


    /**
     * @description Update user settings preferences
     * @param UpdateUserPreferenceRequest $request
     * @return JsonResponse
     */
    public function updateUserPreference(UpdateUserPreferenceRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            //Update user preferences
            $this->userService->updateUserPreferenceService(
                $this->user,
                $validated["category_ids"],
                $validated["author_ids"],
                $validated["source_ids"]
            );
            //Get updated user preferences
            $userPreferences = $this->userService->getUserPreferenceService($this->user);
            //Return response
            return successResponse('User settings updated successfully', $userPreferences);
        } catch (Throwable $throwable) {
            storeErrorLog($throwable, 'User Preference Update Failed: ');
            return errorResponse('Something went wrong', null, 500);
        }
    }

}
