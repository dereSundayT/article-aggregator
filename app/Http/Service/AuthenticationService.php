<?php

namespace App\Http\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

class AuthenticationService
{
    public function __construct(
        protected UserService $userService)
    {
    }

    /**
     * @description: This function is used to register a new user
     * @param string $name
     * @param string $email
     * @param string $password
     * @return null | User
     */
    public function userRegistrationService(string $name,string $email,string $password): ?User
    {
        try {
            return DB::transaction(function () use ($name, $email, $password) {
                  return $this->userService->createUserService($name, $email, $password);
              });
        } catch (Throwable $th) {
            storeErrorLog($th, 'Authentication Service: User Registration Failed: ');
        }
        return null;
    }


    /**
     * @description: This function is used to log in a user
     * @param string $email
     * @param string $password
     * @return array|null
     */
    public function userLoginService(string $email, string $password): ?array
    {
        try {
            if (auth()->attempt(['email' => $email, 'password' => $password])) {
                $user = auth()->user();
                return [
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email
                    ],
                    'token' => $this->generateTokenService($user)
                ];
            }

        } catch (Throwable $th) {
            storeErrorLog($th, 'User Login Failed: ');
        }
        return null;

    }


    /**
     * @description: This function is used to generate a token for a user
     * @param $user
     * @return string
     */
    public function generateTokenService($user): string
    {
        return $user->createToken('authToken')->plainTextToken;
    }

}
