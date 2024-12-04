<?php

namespace App\Http\Service;


use App\Models\User;
use Throwable;

class UserService
{


    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return null | User
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


    public function getUserPreferenceService($user): ?array
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

    public function updateUserPreferenceService($user, array $categories, array $authors,array $sources): bool
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

}






