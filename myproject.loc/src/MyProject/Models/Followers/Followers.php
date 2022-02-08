<?php
namespace MyProject\Models\Followers;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Services\Db;

class Followers extends ActiveRecordEntity
{   
    protected $followerEmail;
    protected $authorEmail;

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getFollowerEmail(): ?string
    {
        return $this->followerEmail;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getAuthorEmail(): ?string
    {
        return $this->authorEmail;
    }

    /**
     * Undocumented function
     *
     * @param User $follower
     * @return void
     */
    public function setFollowerEmail(User $follower): void
    {
        $this->followerEmail = $follower->getEmail();
    }

    /**
     * Undocumented function
     *
     * @param Article $author
     * @return void
     */
    public function setAuthorEmail(Article $author): void
    {
        $this->authorEmail = $author->getAuthorId()->getEmail();
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    static protected function getTableName(): string
    {
        return 'followers_table';
    }

    /**
     * Undocumented function
     *
     * @param string $userEmail
     * @return Followers
     */
    public static function findFollowerData(User $user): ?Followers
    {
       return Followers::findOneByColumn('follower_email', $user->getEmail());
    }



    /**
     * Undocumented function
     *
     * @param User $follower
     * @param Article $author
     * @return void
     */
    public function addNewToFollowersTable(User $follower, Article $author): void
    {    
        $this->setFollowerEmail($follower);
        $this->setAuthorEmail($author);
        $this->create();  
    }

    /**
     * Undocumented function
     *
     * @param User $follower
     * @param Article $author
     * @return void
     */
    public function addMoreToFollowersTable(Article $author): void
    {
        $this->authorEmail .= ',' . $author->getAuthorId()->getEmail();
        $this->save();
    }

    /**
     * Undocumented function
     *
     * @param User $author
     * @return array|null
     */
    public static function getEmailsForMultiplePostage(User $author): ?array
    {
        $db = Db::getInstance();
        
        $email = $author->getEmail();
        $value  = "'" . $email . "' OR followers_table.author_email LIKE '%," . $email . ",%' OR followers_table.author_email LIKE '%," . $email . "' OR followers_table.author_email LIKE '" . $email . ",%'";
        
        $result = $db->query("SELECT DISTINCT follower_email FROM followers_table 
        INNER JOIN users ON users.email_send_if_article = 1 
        WHERE followers_table.author_email = " . $value . ";",
        [],
        static::class);
        
        if ($result === []) { 
            return null;
        }
        return $result;
    }

    public static function getSubscribeDataForMultipleUsers(array $users): ?array
    {
        $db = Db::getInstance();
        $arrayList = [];
        foreach ($users as $user) {
            $value  = $user->getEmail();
            $result = $db->query('SELECT author_email FROM followers_table 
                INNER JOIN users ON followers_table.follower_email = users.email
                WHERE followers_table.follower_email = :value;',
                [':value' => $value],
                static::class
            );
            if ($result !== []) { 
                $arrayList[] = explode(',', $result[0]->getAuthorEmail());
            } else {$arrayList[] = [];}
        }
        return $arrayList;
    }

    public static function getFollowersDataForMultipleUsers(array $users): ?array
    {
        $db = Db::getInstance();
        $arrayList = [];
        foreach ($users as $user) {
            $email = $user->getEmail();
            $value  = "'" . $email . "' OR followers_table.author_email LIKE '%," . $email . ",%' OR followers_table.author_email LIKE '%," . $email . "' OR followers_table.author_email LIKE '" . $email . ",%'";
            $result = $db->query("SELECT users.* FROM users INNER JOIN followers_table ON followers_table.follower_email = users.email
                WHERE followers_table.author_email = ". $value .";",
                [],
                User::class
            );
            if ($result !== []) { 
                $arrayList[] = $result;
            } else {$arrayList[] = [];}
        }
        return $arrayList;
    }

    /**
     * Undocumented function
     *
     * @param string $authorEmail
     * @return void
     */
    public function unFollow(string $authorEmail): void
    {
        $arrayEmail = explode(',', $this->getAuthorEmail());
        $filteredEmail = [];
        foreach($arrayEmail as $email)
        {
            if ($email === $authorEmail) {
                continue;
            }
            $filteredEmail[] = $email;
        }
        $this->authorEmail = implode(',' , $filteredEmail);
        
        if (empty($this->authorEmail)) {
            $this->deleteFromTable($this->followerEmail);
            return;
        }

        $this->save();  
    }

    /**
     * Undocumented function
     *
     * @param string $email
     * @return void
     */
    private function deleteFromTable(string $email): void
    {
        $db = Db::getInstance();
        $db->query('DELETE FROM ' . static::getTableName() . ' WHERE follower_email = :email;',
        [':email' => $email]);
        $this->id = null;
    }
}