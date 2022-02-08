<?php
namespace MyProject\Services;

use MyProject\Exceptions\ActivationException;
use MyProject\Models\Users\User;
use MyProject\Services\Db;

class UserActivationService
{
    private const TABLE_NAME = 'users_activation_codes';

    /**
     * Undocumented function
     *
     * @param User $user
     * @return string
     */
    public static function createActivationCode(User $user): string
    {
        $code = bin2hex(random_bytes(16));
        $db = Db::getInstance();
        
        $db->query(
            'INSERT INTO ' . self::TABLE_NAME . ' (user_id, code) VALUES (:user_id, :code)',
            [
                ':user_id' => $user->getId(),
                ':code' => $code
            ]
        );
        
        return $code;
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @param string $code
     * @return boolean
     */
    public static function checkActivationCode(User $user, string $code): ?bool
    {
        $db = Db::getInstance();
        
        $result = $db->query(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE user_id = :user_id AND code = :code',
            [
                ':user_id' => $user->getId(),
                ':code' => $code
            ]
        ); 
        if ($result === []) {
            return null;
        }

        return true;
    }
    
    /**
     * Undocumented function
     *
     * @param User $user
     * @param string $code
     * @return void
     */
    public static function deleteActivationCode(User $user, string $code):void
    {
        $db = Db::getInstance();
        
        $db->query(
            'DELETE FROM ' .  self::TABLE_NAME . ' WHERE user_id = :user_id AND code = :code',
            [
                ':user_id' => $user->getId(),
                ':code' => $code
            ]
        );
    }
}