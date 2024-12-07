<?php

namespace App\Http\Service;


use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Throwable;

class UserService
{


    /**
     * @description Create user
     * @param string $name
     * @param string $email
     * @param string $password
     * @return null | array
     */
    public function createUserService(string $name, string $email, string $password): ?User
    {
        try {
            return User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password)
            ]);
        } catch (Throwable $throwable) {
            storeErrorLog($throwable, 'User Service: User Creation Failed:');
            return null;
        }
    }


    public function updateUserProfileService(Authenticatable $user,string $name): ?Authenticatable
    {
        try {
            $user->update([
                'name' => $name
            ]);
            return $user->refresh();
        } catch (Throwable $throwable) {
            storeErrorLog($throwable, 'User Service: User Retrieval Failed:');
            return null;
        }
    }

    /**
     * @description Get user preferences
     * @param Authenticatable $user
     * @return null | array
     */
    public function getUserPreferenceService(Authenticatable $user): ?array
    {
        try {
            return [
                "categories" => $user->categories->select('id', 'name'),
                "authors" => $user->authors->select('id', 'name'),
                "sources" => $user->sources->select('id', 'name')
            ];
        } catch (Throwable $throwable) {
            storeErrorLog($throwable, 'User Service: User Retrieval Failed:');
            return null;
        }
    }


    /**
     * @description Update user preferences
     * @param Authenticatable $user
     * @param array $categories
     * @param array $authors
     * @param array $sources
     * @return bool
     */
    public function updateUserPreferenceService(Authenticatable $user, array $categories, array $authors, array $sources): bool
    {
        try {
            $user->categories()->sync($categories);
            $user->authors()->sync($authors);
            $user->sources()->sync($sources);
            return true;
        } catch (Throwable $throwable) {
            storeErrorLog($throwable, 'User Service: User Update Failed:');
        }
        return false;
    }


    public function logoutService(Authenticatable $user): void
    {
        try {
            $user->token()->revoke();
//            $user->tokens()->delete();
        } catch (Throwable $throwable) {
            storeErrorLog($throwable, 'User Service: User Logout Failed:');
        }
    }

}






