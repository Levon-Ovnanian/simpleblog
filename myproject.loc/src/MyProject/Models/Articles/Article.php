<?php
namespace MyProject\Models\Articles;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Services\Db;
use MyProject\Services\UsersAuthService;

class Article extends ActiveRecordEntity
{
    protected $name;
    protected $text;
    protected $authorId;
    protected $createdAt;
    protected $plus;
    protected $minus;
    protected $plusBy;
    protected $minusBy;

    /**
     * Undocumented function
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
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
     * @return User|null
     */
    public function getAuthorId(): ?User
    {
        return User::getById($this->authorId);
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

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getPlusBy(): ?string
    {
        return $this->plusBy;
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getMinusBy(): ?string
    {
        return $this->minusBy;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    protected static function getTableName(): string
    {
        return 'articles';
    }
 
    /**
     * Undocumented function
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = htmlentities($name);
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
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Undocumented function
     *
     * @param User $author
     * @return void
     */
    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();    
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
    public function isUserAnAuthor(): bool
    {
        $author = UsersAuthService::getUserByToken()->getId();
        if ($this->authorId === $author) {
            return true;
        }
        return false;
    }

    /**
     * Undocumented function
     *
     * @param array $fields
     * @param User $author
     * @return Article
     */
    public static function createFromArray(array $fields, User $author): Article
    {   
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Не передано название статьи');
        }
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст статьи');
        }

        $article = new Article();
        $article->setAuthor($author);
        $article->setName($fields['name']);
        $article->setText($fields['text']);
        
        $article->create();
        return $article;          
    }
    
    /**
     * Undocumented function
     *
     * @param array $fields
     * @return Article
     */
    public function updateFromArray(array $fields): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Не передано название статьи');
        }
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст статьи');
        }

        $this->setName($fields['name']);
        $this->setText($fields['text']);
        
        $this->save();
        
        return $this;
    }
    
}