<?php
namespace MyProject\Services;

use MyProject\Models\Users\User;

class UsersAuthService
{
    /**
     * Undocumented function
     *
     * @param User $user
     * @return void
     */
    public static function createToken(User $user): void
    {
        $token = $user->getId() . ':' . $user->getAuthToken();
        setcookie('token', $token, 0, '/', '', false, true);
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @return void
     */
    public static function deleteToken(User $user): void
    {
       setcookie('token', '', 0, '/', '', false, true);
    }

    /**
     * Undocumented function
     *
     * @return User|null
     */
    public static function getUserByToken(): ?User
    {
        $token = $_COOKIE['token'] ?? '';

        if (empty($token)) {
            return null;
        }

        [$userId, $authToken] = explode(':', $token, 2);
        $user = User::getById((int) $userId);

        if ($user === null) {
            return null;
        }
        if ($user->getAuthToken() !== $authToken) {
            return null;
        }
        return $user;
    }
}