<?php
namespace MyProject\Models\Users;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Exceptions\InvalidArgumentException;

class User extends ActiveRecordEntity
{
    protected $nickname;
    protected $email;
    protected $isConfirmed;
    protected $iconPath;
    protected $role;
    protected $status;
    protected $passwordHash;
    protected $authToken;
    protected $createdAt;   
    protected $emailSendIfArticle;    
    protected $emailSendIfComment;    
    protected $emailSendIfAddFollower;   
    protected $emailSendIfDellFollower;
    protected $rating;
    
    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
     
    public function getNickname(): string
    {
        return $this->nickname;
    }
    
    public function getIconPath(): string
    {
        return $this->iconPath;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
    
    public function getEmailSendIfArticle(): bool
    {
        return $this->emailSendIfArticle;
    }

    public function getEmailSendIfComment(): bool
    {
        return $this->emailSendIfComment;
    }

    public function getEmailSendIfAddFollower(): bool
    {
        return $this->emailSendIfAddFollower;
    }

    public function getEmailSendIfDellFollower(): bool
    {
        return $this->emailSendIfDellFollower;
    }

    public function getRating(): int
    {
        return (int)$this->rating;
    }

    public function setIconPath($iconPath): void 
    {
        $this->iconPath = $iconPath;
    }

    public function setRole($role): void 
    {
        $this->role = $role;
    }

    public function setStatus($status): void 
    {
        $this->status = $status;
    }

    public function setEmailSendIfArticle($condition): void                  
    {
        $this->emailSendIfArticle = $condition;
    }

    public function setEmailSendIfComment($condition): void                  
    {
        $this->emailSendIfComment = $condition;
    }

    public function setEmailSendIfAddFollower($condition): void
    {
        $this->emailSendIfAddFollower = $condition;   
    }

    public function setEmailSendIfDellFollower($condition): void
    {
        $this->emailSendIfDellFollower = $condition;  
    }

    public function SetRating($condition): void
    {
        if ($condition === '--') {
            --$this->rating;
        } else {
            ++$this->rating;
        }
        $this->setRate('rating', $this->rating);
    }

   /**
     * Undocumented function
     *
     * @param integer $plus
     * @return void
     */
    public function setPlus($condition): void
    {
        if ($condition === '--') {
            --$this->plus;
        } else {
            ++$this->plus;
        }
        $this->setRate('plus', $this->plus);
        $this->setRate('plus_by', $this->plusBy);
    }

    /**
     * Undocumented function
     *
     * @param integer $minus
     * @return void
     */
    public function setMinus($condition): void
    {
        if ($condition === '--') {
            --$this->minus;
        } else {
            ++$this->minus;
        }
        $this->setRate('minus', $this->minus);
        $this->setRate('minus_by', $this->minusBy);
    }
    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    protected static function getTableName(): string
    {
        return 'users';
    }
    
    /**
     * Undocumented function
     *
     * @return integer
     */
    public function getIsConfirmed(): int
    {
        return $this->isConfirmed;
    } 
    
    /**
     * Undocumented function
     *
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
    
    /**
     * Undocumented function
     *
     * @param array $userData
     * @return User
     */
    public static function signUp(array $userData): User
    {
        if (empty($userData['nickname'])) {
            throw new InvalidArgumentException('Не передан nickname');
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $userData['nickname'])) {
            throw new InvalidArgumentException('Nickname может состоять только из символов латинского алфавита и цифр');
        }

        if (empty($userData['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }
        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email некорректен');
        }

        if (empty($userData['password'])) {
            throw new InvalidArgumentException('Не передан password');
        }
        if (mb_strlen($userData['password']) < 8) {
            throw new InvalidArgumentException('Пароль должен быть не менее 8 символов');
        }

        if (static::findOneByColumn('nickname', $userData['nickname']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким nickname уже существует');
        }
        if (static::findOneByColumn('email', $userData['email']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким email уже существует');
        }

        $user = new User();
        $user->nickname = htmlentities($userData['nickname']);
        $user->email = htmlentities($userData['email']);
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->isConfirmed = false;
        $user->role = 'user';
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->create();

        return $user;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function activation(): void
    {
        $this->isConfirmed = 1;
        $this->save();
    }      

    /**
     * Undocumented function
     *
     * @param array $loginData
     * @return User
     */
    public static function login(array $loginData): User
    {
        if (empty($loginData['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }

        if (empty($loginData['password'])) {
            throw new InvalidArgumentException('Не передан password');
        }

        $user = User::findOneByColumn('email', $loginData['email']);
        if ($user === null) {
            throw new InvalidArgumentException('Нет пользователя с таким email');
        }

        if (!password_verify($loginData['password'], $user->getPasswordHash())) {
            throw new InvalidArgumentException('Неправильный пароль');
        }

        if (!$user->isConfirmed) {
            throw new InvalidArgumentException('Пользователь не подтверждён');
        }

        $user->refreshAuthToken();
        $user->save();

        return $user;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private function refreshAuthToken(): void
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }

}