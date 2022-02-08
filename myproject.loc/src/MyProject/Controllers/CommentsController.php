<?php
namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;
use MyProject\Models\Users\User;
use MyProject\Services\EmailSender;

class CommentsController extends AbstractController
{   
    /**
     * Undocumented function
     *
     * @param integer $articleId
     * @return void
     */
    public function createComment(int $articleId): void
    {
        try{
            if ($this->user === null) {
                throw new UnauthorizedException();
            }
            
            $article = Article::getById($articleId);
            if ($article === null) {
                throw new NotFoundException();
            }

            if ($this->user->getStatus() === 'blocked') {
                throw new ForbiddenException('Статус Вашего акаунта не позволяет написать комментарий');
            }

            $newComment = Comment::createFromArray($_POST, $this->user, $article);      
            $emailSendPermission = $article->getAuthorId()->getEmailSendIfComment();
            $commentAuthorNotArticleAuthor = $this->user->getId() !== $article->getAuthorId()->getId();
            
            if ($emailSendPermission AND $commentAuthorNotArticleAuthor) {
                EmailSender::send($article->getAuthorId(), 'Новый комментарий!', 'newComment.php',
                    [
                        'articleId' => $article->getId(),
                        'commentId' => $newComment->getId()
                    ]
                );
            }

        } catch (ForbiddenException $e) {
            $this->view->renderHtml('errors/401.php', ['error' => $e->getMessage(), 'link' => 'условная ссылка для связи с администратором'], 401);
            return;
        }   

        header('Location: /articles/' . $article->getId() . '#' . $newComment->getId(), true, 302);
        exit();  
    }
    
    /**
     * Undocumented function
     *
     * @param integer $commentId
     * @return void
     */
    public function editComment(int $articleId, int $commentId): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        if ($this->user->isAdmin() === false) {
            throw new UnauthorizedException('Редактировать комментарии может только администратор');
        }
        
        $article = Article::getById($articleId);
        if ($article === null) {
            throw new NotFoundException('Статья не найдена');
        }
        $comment = Comment::getById($commentId);
        if ($comment === null) {
            throw new NotFoundException('Комментарий для редактирования не найден');
        }
        
        if (!empty($_POST['text'])) {
            try {
                $comment->updateFromArray($_POST);
                header('Location: /articles/' . $article->getId(). '#' . $comment->getId(), true, 302);
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('comments/editComment.php', ['error' => $e->getMessage(), 'article' => $article, 'comment' => $comment]);
                return;
            }
        }

        $this->view->renderHtml('comments/EditComment.php', ['article' => $article, 'comment' => $comment]);
    }
    
    /**
     * Undocumented function
     *
     * @param integer $articleId
     * @param integer $commentId
     * @return void
     */
    public function answerComment(int $articleId, int $commentId): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        
        $article = Article::getById($articleId);
        if ($article === null) {
            throw new NotFoundException('Статья не найдена');
        }
        $sourceComment = Comment::getById($commentId);
        if ($sourceComment === null) {
            throw new NotFoundException('Комментарий на который вы хотите ответить не найден');
        }

        if (!empty($_POST)) {
            try {
                $comment = Comment::createAnswerOnComment($_POST, $this->user, $article, $sourceComment);
                $sourceCommentAuthor = $sourceComment->getUserId();
                $emailSendPermission = $sourceCommentAuthor->getEmailSendIfComment();
                $commentAuthorNotArticleAuthor = $this->user->getId() !== $article->getAuthorId()->getId();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('comments/answerComment.php', ['error' => $e->getMessage(), 'article' => $article, 'sourceComment' => $sourceComment]);
                return;
            }
            if ($emailSendPermission AND $commentAuthorNotArticleAuthor) {
                EmailSender::send($sourceCommentAuthor, 'На Ваш комментарий ответили!', 'newAnswer.php',
                    [
                        'articleId' => $article->getId(),
                        'commentId' => $comment->getId()
                    ]
                );
            }
            header('Location: /articles/' . $article->getId() . '#' . $comment->getId(), true, 302);
            exit();
        }
        $this->view->renderHtml('comments/answerComment.php', ['article' => $article, 'sourceComment' => $sourceComment]);
    }

    /**
     * Undocumented function
     *
     * @param integer $articleId
     * @param integer $commentId
     * @return void
     */
    public function plusComment(int $articleId, int $commentId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        
        $article = Article::getById($articleId);
        if ($article === null) {
            throw new NotFoundException('Статья не найдена');
        }
        
        $comment = Comment::getById($commentId);
        if ($comment === null) {
            throw new NotFoundException('Комментарий не найден');
        }

        $userToRate = $comment->getUserId();
        if ($userToRate === null) {
            throw new NotFoundException('Автор статьи не найден');
        }

        if (!empty($comment->getPlusBy())) {

            $isAlreadyRated = $comment->compareWithArray($this->user->getEmail(), $comment->getPlusBy());
            if ($isAlreadyRated === true) {
                $comment->unRate($this->user->getEmail(), $comment->getPlusBy(), 'plus');
                $comment->setPlus('--');
                $userToRate->SetRating('--');   
            } else { 
                $comment->addMoreToTable('plus', $this->user);
                $comment->setPlus('++');
                $userToRate->SetRating('++');
            } 
        } else {
            $comment->addNewToTable('plus', $this->user);
            $comment->setPlus('++');
            $userToRate->SetRating('++');
        } 
        
        header('Location: /articles/' . $article->getId() . '#' . $comment->getId(), true, 302);
        exit();
    }

    /**
     * Undocumented function
     *
     * @param integer $articleId
     * @param integer $commentId
     * @return void
     */
    public function minusComment(int $articleId, int $commentId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $article = Article::getById($articleId);
        if ($article === null) {
            throw new NotFoundException('Статья не найдена');
        }
        
        $comment = Comment::getById($commentId);
        if ($comment === null) {
            throw new NotFoundException('Комментарий не найден');
        }

        $userToRate = $comment->getUserId();
        if ($userToRate === null) {
            throw new NotFoundException('Автор статьи не найден');
        }

        if (!empty($comment->getMinusBy())) {

            $isAlreadyRated = $comment->compareWithArray($this->user->getEmail(), $comment->getMinusBy());
            if ($isAlreadyRated === true) {
                $comment->unRate($this->user->getEmail(), $comment->getMinusBy(), 'minus');
                $comment->setMinus('++');
                $userToRate->SetRating('++');   
            } else { 
                $comment->addMoreToTable('minus', $this->user);
                $comment->setMinus('--');
                $userToRate->SetRating('--'); 
            } 
        } else {
            $comment->addNewToTable('minus', $this->user);
            $comment->setMinus('--');
            $userToRate->SetRating('--'); 
        } 
       
        header('Location: /articles/' . $article->getId() . '#' . $comment->getId(), true, 302);
        exit();
    }

    /**
     * Undocumented function
     *
     * @param integer $commentId
     * @return void
     */
    public function deleteComment(int $articleId, int $commentId): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        if ($this->user->isAdmin() === false) {
            throw new UnauthorizedException('Удалять комментарии может только администратор');
        }

        $comment = Comment::getById($commentId);
        if ($comment === null) {
            throw new NotFoundException('Комментарий не найден');
        }

        Comment::deleteComment($comment);
        header('Location: /articles/' . $articleId, true, 302);
        exit();
    }    
}