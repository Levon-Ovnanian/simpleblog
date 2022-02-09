<?php
namespace MyProject\Models\Comments;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Services\Db;

class Comment extends ActiveRecordEntity
{   
    protected $userId;
    protected $articleId;
    protected $text;
    protected $createdAt;
    protected $redactedAt;
    protected $sourceCommentId;
    protected $commentKey;
    protected $plus;
    protected $minus;
    protected $plusBy;
    protected $minusBy;
    
    /**
     * Undocumented function
     *
     * @return string
     */
    protected static function getTableName(): string
    {
        return 'users_comments';
    }

    /**
     * Undocumented function
     *
     * @return User
     */
    public function getUserId(): User
    {
        return User::getById($this->userId);
    }
    
    /**
     * Undocumented function
     *
     * @return Article
     */
    public function getArticle(): Article
    {
        return Article::getById($this->articleId);
    }

     /**
     * Undocumented function
     *
     * @return Article
     */
    public function getArticleId(): int
    {
        return $this->articleId;
    }
    
    /**
     * Undocumented function
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

     /**
     * Undocumented function
     *
     * @return string
     */
    public function getShortText(int $count): string
    {
        return mb_strimwidth($this->text, 0, $count);
    }
    
    /**
     * Undocumented function
     *
     * @return string
     */
    public function getParsedText(): string
    {
        $parser = new \Parsedown();
        return $parser->text($this->getText());
    }
    
    /**
     * Undocumented function
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getRedactedAt(): ?string
    {
        return $this->redactedAt;
    }

    /**
     * Undocumented function
     *
     * @return integer|null
     */
    public function getSourceCommentId(): ?int
    {
        return $this->sourceCommentId;
    }

    /**
     * Undocumented function
     *
     * @return integer
     */
    public function getCommentKey(): int
    {
        return $this->commentKey;
    }

    /**
     * Undocumented function
     *
     * @return integer
     */
    public function getPlus(): int
    {
        return (int)$this->plus;
    }

    /**
     * Undocumented function
     *
     * @return integer
     */
    public function getMinus(): int
    {
        return (int)$this->minus;
    }

    public function getPlusBy()
    {
        return $this->plusBy;
    }

    /**
     * Undocumented function
     *
     * @return integer
     */
    public function getMinusBy()
    {
        return $this->minusBy;
    }

    /**
     * Undocumented function
     *
     * @return Comment
     */
    public function getSourceComment(): Comment
    {
        return self::getById($this->sourceCommentId);
    }

    /**
     * Undocumented function
     *
     * @return User
     */
    public function getSourceCommentUser(): User
    {
       $sourceComment = $this->getSourceComment();
       return User::getById($sourceComment->userId);
    }

    public function getCount(): ?int
    {
        return $this->count;
    }
    
    /**
     * Undocumented function
     *
     * @param User $author
     * @return void
     */
    public function setUserId(User $author): void
    {
        $this->userId = $author->getId();
    }

    /**
     * Undocumented function
     *
     * @param Article $article
     * @return void
     */
    public function setArticleId(Article $article): void
    {
        $this->articleId = $article->getId();
    }

    /**
     * Undocumented function
     *
     * @param string $text
     * @return void
     */
    public function setText(string $text): void
    {
        $this->text = htmlentities($text);    
    }

    /**
     * Undocumented function
     *
     * @param string $createdAt
     * @return void
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Undocumented function
     *
     * @param string $redactedAt
     * @return void
     */
    public function setRedactedAt(string $redactedAt): void
    {
        $this->redactedAt = $redactedAt;
    }

    /**
     * Undocumented function
     *
     * @param Comment $sourceComment
     * @return void
     */
    public function setSourceCommentId(Comment $sourceComment): void
    {
        $this->sourceCommentId = $sourceComment->getId();
    }

    /**
     * Undocumented function
     *
     * @param Comment $sourceComment
     * @return void
     */
    public function setCommentKey(Comment $sourceComment): void
    {
        $this->commentKey = $sourceComment->getCommentKey();
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
     * @param integer $value
     * @return array|null
     */
    public static function showOrderedByCommentKey(int $value): ?array
    {
        $db = Db::getInstance();
        $result = $db->query('SELECT * FROM ' . static::getTableName() .
            ' WHERE article_id = :value ORDER BY comment_key;',
            [':value' => $value],
            static::class
        );

        if ($result === []) {
            return null;
        }
        return $result;
    }

    public static function getCommentsArrayForAdminPanel(array $values): ?array 
    {   
        $db = Db::getInstance();
        foreach ($values as $value) {
            $sql = $db->query('SELECT * FROM ' . static::getTableName() . ' WHERE article_id = :value ORDER BY comment_key LIMIT 5;',
                [':value' => $value->id],
                static::class
            );
            if ($sql !== []) { 
                $result[] = $sql;
            }       
        }
        if ($result === []) { 
            return null;
        }    
        return $result;    
    }
    
    
    /**
     * Undocumented function
     *
     * @param array $commentData
     * @param User $author
     * @param Article $article
     * @return Comment
     */
    public static function createFromArray(array $commentData, User $author, Article $article): Comment
    {   
        if (!strlen(trim($commentData['text'])) AND !preg_match('/^[0]$/', $commentData['text'])) {
            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }  
        if (empty($commentData['text']) AND !preg_match('/^[0]$/', $commentData['text'])) {
            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }
        
        if (preg_match('/^[0]$/', $commentData['text'])) {
            $commentData['text'] = '0 ';
        }
        
        $comment = new Comment();
        $comment->setUserId($author);
        $comment->setArticleId($article);
        $comment->setText($commentData['text']);
        
        $comment->create();
       
        $comment->setCommentKeyIfParentComment($comment->id); 
        return $comment;
    }
    
    /**
     * Undocumented function
     *
     * @param array $fields
     * @param Article $article
     * @param Comment $sourceComment
     * @return void
     */
    public static function createAnswerOnComment(array $fields, User $user, Article $article, Comment $sourceComment): ?Comment
    {  
        if (!strlen(trim($fields['text'])) AND !preg_match('/^[0]$/', $fields['text'])) {
            throw new InvalidArgumentException('Не передан текст комментария');
        }  
        if (empty($fields['text']) AND !preg_match('/^[0]$/', $fields['text'])) {
            throw new InvalidArgumentException('Не передан текст комментария');
        }
        
        if (preg_match('/^[0]$/', $fields['text'])) {
            $fields['text'] = '0 ';
        }

        $comment = new Comment();
        $comment->setUserId($user);
        $comment->setArticleId($article);
        $comment->setText($fields['text']);
        $comment->setSourceCommentId($sourceComment);
        $comment->setCommentKey($sourceComment);
        
        $comment->create();
        return $comment;
    }

    /**
     * Undocumented function
     *
     * @param array $fields
     * @return Comment
     */
    public function updateFromArray(array $fields): Comment
    {
        if (!strlen(trim($fields['text'])) AND !preg_match('/^[0]$/', $fields['text'])) {
            throw new InvalidArgumentException('Не передан текст комментария');
        }  
        if (empty($fields['text']) AND !preg_match('/^[0]$/', $fields['text'])) {
            throw new InvalidArgumentException('Не передан текст комментария');
        }
        
        if (preg_match('/^[0]$/', $fields['text'])) {
            $fields['text'] = '0 ';
        }
        
        $this->setText($fields['text']);
        $this->save();
        $this->setRedactedTime('CURRENT_TIMESTAMP');
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private function setRedactedTime(): void
    {
        $db = Db::getInstance();
        
        $sql = 'UPDATE ' . static::getTableName() . ' set redacted_at = CURRENT_TIMESTAMP WHERE id = '. $this->id;
        $db->query($sql, [], static::class);
        $this->refresh();
    }

    private function setCommentKeyIfParentComment(int $id): void
    {
        $sql = 'UPDATE ' . static::getTableName() . ' set comment_key = :id WHERE id = '. $this->id;
        
        $db = Db::getInstance();
        $db->query($sql, [':id' => $id], static::class);
    }      

    /**
     * Undocumented function
     *
     * @param Comment $comment
     * @return void
     */
    public static function deleteComment(Comment $comment): void
    {
        if ($comment->getSourceCommentId() == null) {
            $comment->deleteByColumn('comment_key', $comment->id);
        } else { 
            $comment->deleteByColumn('source_comment_id', $comment->id);
            $comment->delete();
        }        
    }

    /**
     * Undocumented function
     *
     * @param int $articleId
     * @return void
     */
    public static function deleteWithArticle(int $articleId): void
    {
        $comment = new Comment();
        $comment->deleteByColumn('article_id', $articleId);
    }
}