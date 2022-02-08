<?php
namespace MyProject\Controllers;

use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Followers\Followers;
use MyProject\Services\EmailSender;

class FollowersController extends AbstractController
{
    private $follower;

    public function __construct()
    {
        parent::__construct();
        if ($follower = Followers::findFollowerData($this->user)) {
                $this->follower = $follower;
        } else { 
            $this->follower = new Followers(); 
        }
    }
    /**
     * Undocumented function
     *
     * @param integer $articleId
     * @return void
     */
    public function followAuthor(int $articleId, string $path): void
    {   
        $user = $this->user;
        if ($user === null) {
            throw new UnauthorizedException();
        }
        
        $article = Article::getById($articleId);
        if ($article === null) {
            throw new NotFoundException('Статья не найдена');
        }

        $follower = $this->follower;
        $emailSendPermission = $article->getAuthorId()->getEmailSendIfAddFollower();

        if (!empty($_POST['follow'])) {            
            
            if (!empty($follower->getFollowerEmail())) {
                $follower->addMoreToFollowersTable($article);
            } else { 
                $follower->addNewToFollowersTable($user, $article);
            } 
            if ($emailSendPermission) {
                EmailSender::send($article->getAuthorId(), 'На вас подписались!', 'newFollower.php',
                    [
                        'article' => $article->getName(),
                        'follower' => $user->getNickname(),
                    ]
                );
            }
        }
        
        header('Location: /' . $path, true, 302);
        exit();
    }

    /**
     * Undocumented function
     *
     * @param integer $articleId
     * @return void
     */
    public function unFollowAuthor(int $articleId, string $path): void
    {   
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        
        $article = Article::getById($articleId);
        if ($article === null) {
            throw new NotFoundException('Статья не найдена');
        }
        $emailSendPermission = $article->getAuthorId()->getEmailSendIfDellFollower();
        
        if (!empty($_POST['unfollow'])) {           
            $this->follower->unFollow($article->getAuthorId()->getEmail());
            if ($emailSendPermission) {
                EmailSender::send($article->getAuthorId(), 'От вас отписались :(', 'unFollow.php',
                    [
                        'article' => $article->getName(),
                        'follower' => $this->user->getNickname(),
                    ]
                );
            }
        }

        header('Location: /' . $path, true, 302);
        exit();
    }
}