<?php

namespace App\Http\Service;
use App\Models\User;
use Throwable;

class AuthenticationService
{
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
            return User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password)
            ]);
        } catch (Throwable $th) {
            storeErrorLog($th, 'User Registration Failed: ');
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


    public function generateTokenService($user): string
    {
        return $user->createToken('authToken')->plainTextToken;
    }

}
