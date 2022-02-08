<?php
namespace MyProject\Controllers\Api;

use MyProject\Controllers\AbstractController;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;


class ArticlesApiController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @param integer $articleId
     * @return void
     */
    public function view(int $articleId): void
    {
        $article = Article::getById($articleId);
        if ($article === null) {
            throw new NotFoundException();
        }
        
        $this->view->displayJson(['articles' => [$article]]);        
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function add(): void
    {
        $input = $this->getInputData();
        $articleFromRequest = $input['articles'][0];

        $authorId = $articleFromRequest['author_id'];
        $author = User::getById($authorId);
        $article = Article::createFromArray($articleFromRequest, $author);

        header('Location: /api/articles/' . $article->getId(), true, 302);
    }
   
} 