<?php
namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;
use MyProject\Models\Followers\Followers;
use MyProject\Models\Users\User;
use MyProject\Services\DateCounter;
use MyProject\Services\EmailSender;

/**
 * class extends AbstractController;
 * class controls actions for articles and partially for comments;
 * it has its own string property $articleId and gets another two as extendable class:
 * protected $view - association with an object of class View,
 * protected $user - association with an object of class UsersAuthService; 
 */
class ArticlesController extends AbstractController
{
    /**
     * function initiates and fills variables to pass them for rendering to method renderHtml() of class View;
     *
     * @param string $articleId - article id for viewing in template;
     * @return void
     */
    public function view(string $articleId): void
    {
        $articles = Article::getById($articleId); ///gets an object of class Article formed by method getById();
        if ($articles === null) { ///if non of article by given id throw exception;
            throw new NotFoundException('Статья не найдена');
        }
        $comments = Comment::showOrderedByCommentKey($articleId); ///gets an array of objects of comments sorted by comments key;
       
        if ($this->user) {
            if ($follower = Followers::findFollowerData($this->user)) { ///queries data about users subscriptions;
                $isAlreadySubscribed = $follower->compareWithArray($articles->getAuthorId()->getEmail(), $follower->getAuthorEmail()); ///checking if user subscribed on author;
            } 
        }
        if ($comments !== null) {
            $setTimeZone = new DateCounter("ini_get('date.timezone')"); ///sets timezone in accordance with it ini .ini settings;
            $createdAtDates = $setTimeZone::getDifference($comments, 'getCreatedAt'); ///gets difference time between creation of comment and current time;
            $redactedAtDates = $setTimeZone::getDifference($comments, 'getRedactedAt'); ///gets difference time between redaction of comment and current time;    
        }
        $this->view->renderHtml('articles/view.php', ///passes all collected data for further rendering;
            [
                'articles' => $articles,
                'follower' => $follower,
                'comments' => $comments,
                'isAlreadySubscribed' => $isAlreadySubscribed,
                'createdAtDates' => $createdAtDates,
                'redactedAtDates' => $redactedAtDates
            ]
        );
    }

    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function add(): void
    {
        try {
            if ($this->user === null) {
                throw new UnauthorizedException();
            }
            if ($this->user->getStatus() === 'limited' || $this->user->getStatus() === 'blocked') {
                throw new ForbiddenException('Статус Вашего акаунта не позволяет создать статью');
            }
        
            if (!empty($_POST)) {        
                $article = Article::createFromArray($_POST, $this->user);
                $emailArray = Followers::getEmailsForMultiplePostage($this->user);
                if ($emailArray !== null) {
                    EmailSender::multiplePostageToFollowers($emailArray, 'Новая статья для вас!', 'newArticle.php',
                        [
                            'author' => $this->user->getNickname(),
                            'articleName' => $_POST['name']
                        ]
                    );
                }
                header('Location: /articles/' . $article->getId(), true, 302);
                exit();    
            }
        } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/add.php', ['error' => $e->getMessage()]);
                return;
        } catch (ForbiddenException $e) {
                $this->view->renderHtml('errors/401.php', ['error' => $e->getMessage(), 'link' => 'условная ссылка для связи с администратором'], 401);
                return;
        }    
        $this->view->renderHtml('articles/add.php');
    }

   /**
   * Undocumented function
   *
   * @param integer $articleId
   * @param [type] $currentPage
   * @param [type] $searchPanelName
   * @param [type] $searchArgs
   * @return void
   */
    public function edit(int $articleId, int $currentPage, string $searchPanelName, string $searchArgs): void
    {
        $article = Article::getById($articleId);

        $searchArgAsArray = $_POST['mainSearchPanelArguments'] ? [$_POST['mainSearchPanel'], $_POST['mainSearchPanelArguments']]: $searchArgs = explode('/', $searchArgs);
        if ($searchArgAsArray[0] !== 'name' XOR $searchArgAsArray[0] !== 'text' XOR $searchArgAsArray[0] !== 'nickname') {
            $searchArgAsArray[0] ='null';
        }
        
        try{         
            if ($article === null) {
                throw new NotFoundException('Статья не найдена');
            }
            if ($this->user === null) {
                throw new UnauthorizedException();
            }
            if ($this->user->isAdmin() === false) {
                throw new ForbiddenException('Редактировать статью может только администратор'); 
            }
            if (!empty($_POST)) {
                $article->updateFromArray($_POST);
                header('Location: /adminpanel/' . $currentPage . '/' . $searchPanelName .  '/' . $searchArgAsArray[0] . '/' . $searchArgAsArray[1], true, 302);
                exit();
            }
        } catch (InvalidArgumentException $e) {
            $this->view->renderHtml('articles/edit.php', ['error' => $e->getMessage(), 'article' => $article]);
            return;
        } 
        
        $this->view->renderHtml('articles/edit.php', 
            [
                'article' => $article,
                'currentPage' => $currentPage, 
                'orderBy' => $searchPanelName, 
                'searchPanelArgs' => $searchArgs
            ]
                
        );
    }

    /**
     * Undocumented function
     *
     * @param integer $articleId
     * @return void
     */
   
    public function delete(int $articleId, int $currentPage, string $searchPanelName, string $searchArgs): void 
    {
        $articles = Article::getById($articleId);
        
        $searchArgAsArray = $_POST['mainSearchPanelArguments'] ? [$_POST['mainSearchPanel'], $_POST['mainSearchPanelArguments']]: $searchArgs = explode('/', $searchArgs);
        if ($searchArgAsArray[0] !== 'name' XOR $searchArgAsArray[0] !== 'text' XOR $searchArgAsArray[0] !== 'nickname') {
            $searchArgAsArray[0] ='null';
        }

        if ($articles === null) {
            throw new NotFoundException();
        }
        if ($this->user->isAdmin() === false) {
            throw new ForbiddenException('Удалить статью может только администратор');
        }

        Comment::deleteWithArticle($articleId);
        $articles->delete();
        header('Location: /adminpanel/' . $currentPage . '/' . $searchPanelName .  '/' . $searchArgAsArray[0] . '/' . $searchArgAsArray[1], true, 302);
        exit();
    }

    /**
     * Undocumented function
     *
     * @param integer $articleId
     * @param integer $userId
     * @return void
     */
    public function plusArticle(int $articleId, int $userId, int $pageNum, string $orderBy, string $searchArgs)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $article = Article::getById($articleId);
        if ($article === null) {
            throw new NotFoundException('Статья не найдена');
        }
        
        $userToRate = User::getById($userId);
        if ($userToRate === null) {
            throw new NotFoundException('Автор статьи не найден');
        }

        if (!empty($article->getPlusBy())) {

            $isAlreadyRated = $article->compareWithArray($this->user->getEmail(), $article->getPlusBy());
            if ($isAlreadyRated === true) {
                $article->unRate($this->user->getEmail(), $article->getPlusBy(), 'plus');
                $article->setPlus('--'); 
                $userToRate->SetRating('--'); 
            } else { 
                $article->addMoreToTable('plus', $this->user);
                $article->setPlus('++');
                $userToRate->SetRating('++');
            } 
        } else {
            $article->addNewToTable('plus', $this->user);
            $article->setPlus('++');
            $userToRate->SetRating('++');
        } 
        
        if ($pageNum !== 0) {
            header('Location: /' . $pageNum . '/' . $orderBy . '/'. $searchArgs, true, 302);
            exit();
        }

        header('Location: /articles/' . $article->getId(), true, 302);
        exit();
    }

    /**
     * Undocumented function
     *
     * @param integer $articleId
     * @param integer $userId
     * @return void
     */
    public function minusArticle(int $articleId, int $userId, int $pageNum, string $orderBy, string $searchArgs)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $article = Article::getById($articleId);
        if ($article === null) {
            throw new NotFoundException('Статья не найдена');
        }
        
        $userToRate = User::getById($userId);
        if ($userToRate === null) {
            throw new NotFoundException('Автор статьи не найден');
        }

        if (!empty($article->getMinusBy())) {

            $isAlreadyRated = $article->compareWithArray($this->user->getEmail(), $article->getMinusBy());
            if ($isAlreadyRated === true) {
                $article->unRate($this->user->getEmail(), $article->getMinusBy(), 'minus');
                $article->setMinus('++');
                $userToRate->SetRating('++');   
            } else { 
                $article->addMoreToTable('minus', $this->user);
                $article->setMinus('--');
                $userToRate->SetRating('--'); 
            } 
        } else {
            $article->addNewToTable('minus', $this->user);
            $article->setMinus('--');
            $userToRate->SetRating('--'); 
        } 
       
        if ($pageNum !== 0) {
            header('Location: /' . $pageNum . '/' . $orderBy . '/'. $searchArgs, true, 302);
            exit();
        }

        header('Location: /articles/' . $article->getId(), true, 302);
        exit();
    }
}



