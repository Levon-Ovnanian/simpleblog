<?php
namespace MyProject\Controllers;

use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;

class MainController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function main(): void
    {
        $this->page(1, 'DESC', 'null/null');
    }

   /**
    * Undocumented function
    *
    * @param integer $pageNum
    * @param string $articlesOrder
    * @param string $searchArgs
    * @return void
    */
    public function page(int $pageNum, string $articlesOrder, string $searchArgs): void
    {
        try {
            $itemsPerPage = 5;    
            
            $orderBy = $_POST['orderBy'] ? $_POST['orderBy']: $articlesOrder;
            $searchArgAsArray = $_POST['mainSearchPanelArguments'] ? [$_POST['mainSearchPanel'], $_POST['mainSearchPanelArguments']]: $searchArgs = explode('/', $searchArgs);
            
            $checkForArticles = Article::findAll();
            if ($checkForArticles === []) {
                throw new NotFoundException('Привет! К сожалению, у нас еще нет статей! Но ты сам можешь создать ее :)');
            }

            if ($searchArgAsArray[0] !== 'name' XOR $searchArgAsArray[0] !== 'text' XOR $searchArgAsArray[0] !== 'nickname') {
                $searchArgAsArray[0] ='null';
            }

            if ($searchArgAsArray[0] !== 'null') {

                if ($orderBy === 'ASC') { 
                    $pagesCountAsArray = Article::getPagesCountWithSearchArgs($itemsPerPage, $searchArgAsArray);
                    $articlesCount = $pagesCountAsArray[1];
                    if ($articlesCount == false) {
                        throw new NotFoundException('Привет! К сожалению, у нас нет статей c тиким фильтром!');
                    }
                    $pagesCount = $pagesCountAsArray[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        throw new NotFoundException('Привет! Ты куда-то не туда перешел :)');
                    }
                    $articles = Article::getPageWithSearchArgsASC($pageNum, $itemsPerPage, $searchArgAsArray);
                }
                elseif ($orderBy === 'DESC') {
                    $pagesCountAsArray = Article::getPagesCountWithSearchArgs($itemsPerPage, $searchArgAsArray);
                    $articlesCount = $pagesCountAsArray[1];
                    if ($articlesCount == false) {
                        throw new NotFoundException('Привет! К сожалению, у нас нет статей c тиким фильтром!');
                    }
                    $pagesCount = $pagesCountAsArray[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        throw new NotFoundException('Привет! Ты куда-то не туда перешел :)');
                    }
                    $articles = Article::getPageWithSearchArgs($pageNum, $itemsPerPage, $searchArgAsArray);
                }
                elseif ($orderBy === 'withComments') {
                    $pagesCountAsArray = Article::getPagesWithCommentsCount($itemsPerPage, $searchArgAsArray);
                    $articlesCount = $pagesCountAsArray[1];
                    if ($articlesCount == false) {
                        throw new NotFoundException('Привет! К сожалению, у нас нет статей c тиким фильтром!');
                    }
                    $pagesCount = $pagesCountAsArray[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        throw new NotFoundException('Привет! Ты куда-то не туда перешел :)');
                    }
                    $articles = Article::getArticlesWithCommentsBySearchArgsLimited($pageNum, $itemsPerPage, $searchArgAsArray);
                }
                elseif ($orderBy === 'withCommentsASC') {
                    $pagesCountAsArray = Article::getPagesWithCommentsCount($itemsPerPage, $searchArgAsArray);
                    $articlesCount = $pagesCountAsArray[1];
                    if ($articlesCount == false) {
                        throw new NotFoundException('Привет! К сожалению, у нас еще нет статей c комментариями! Начни общение первым :)');
                    }
                    $pagesCount = $pagesCountAsArray[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        throw new NotFoundException('Привет! Ты куда-то не туда перешел :)');
                    }
                    $articles = Article::getArticlesWithCommentsBySearchArgsLimitedASC($pageNum, $itemsPerPage, $searchArgAsArray);
                }
                elseif ($orderBy === 'ratingDESC') {
                    $pagesCountAsArray = Article::getPagesCountWithSearchArgs($itemsPerPage, $searchArgAsArray, 'ratingDESC');
                    $articlesCount = $pagesCountAsArray[1];
                    if ($articlesCount == false) {
                        throw new NotFoundException('Привет! К сожалению, у нас нет статей c тиким фильтром!');
                    }
                    $pagesCount = $pagesCountAsArray[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        throw new NotFoundException('Привет! Ты куда-то не туда перешел :)');
                    }
                    $articles = Article::getPageWithSearchArgs($pageNum, $itemsPerPage, $searchArgAsArray, 'plus DESC', 'ratingDESC');
                } else {
                    $orderBy = 'DESC';
                    $pagesCountAsArray = Article::getPagesCountWithSearchArgs($itemsPerPage, $searchArgAsArray);
                    $articlesCount = $pagesCountAsArray[1];
                    if ($articlesCount == false) {
                        throw new NotFoundException('Привет! К сожалению, у нас нет статей c тиким фильтром!');
                    }
                    $pagesCount = $pagesCountAsArray[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        throw new NotFoundException('Привет! Ты куда-то не туда перешел :)');
                    }
                    $articles = Article::getPageWithSearchArgs($pageNum, $itemsPerPage, $searchArgAsArray);
                }
             
            } else {

                if ($orderBy === 'ASC') {                  
                    $pagesCountAsArray = Article::getPagesCount($itemsPerPage);
                    $pagesCount =  $pagesCountAsArray[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        throw new NotFoundException('Привет! Ты куда-то не туда перешел :)');
                    }
                    $articlesCount = $pagesCountAsArray[1];
                    $articles = Article::getPageASC($pageNum, $itemsPerPage, 'articles.id ASC');
                }
                elseif ($orderBy === 'DESC') {                  
                    $pagesCountAsArray = Article::getPagesCount($itemsPerPage);
                    $pagesCount =  $pagesCountAsArray[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        throw new NotFoundException('Привет! Ты куда-то не туда перешел :)');
                    }
                    $articlesCount = $pagesCountAsArray[1];
                    $articles = Article::getPage($pageNum, $itemsPerPage, 'articles.id DESC');
                }
                elseif ($orderBy === 'withComments') {
                    $pagesCountAsArray = Article::getPagesWithCommentsCount($itemsPerPage);
                    $articlesCount = $pagesCountAsArray[1];
                    if ($articlesCount == false) {
                        throw new NotFoundException('Привет! К сожалению, у нас еще нет статей c комментариями! Начни общение первым :)');
                    }
                    $pagesCount = $pagesCountAsArray[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        throw new NotFoundException('Привет! Ты куда-то не туда перешел :)');
                    }
                    $articles = Article::getArticlesWithCommentsLimited($pageNum, $itemsPerPage, 'DESC');
                }
                elseif ($orderBy === 'withCommentsASC') {
                    $pagesCountAsArray = Article::getPagesWithCommentsCount($itemsPerPage);
                    $articlesCount = $pagesCountAsArray[1];
                    if ($articlesCount == false) {
                        throw new NotFoundException('Привет! К сожалению, у нас еще нет статей c комментариями! Начни общение первым :)');
                    }
                    $pagesCount = $pagesCountAsArray[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        throw new NotFoundException('Привет! Ты куда-то не туда перешел :)');
                    }
                    $articles = Article::getArticlesWithCommentsASCLimited($pageNum, $itemsPerPage, 'ASC');
                } 
                elseif ($orderBy === 'ratingDESC') {                  
                    $pagesCountAsArray = Article::getPagesCount($itemsPerPage, 'ratingDESC');
                    $pagesCount =  $pagesCountAsArray[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        throw new NotFoundException('Привет! Ты куда-то не туда перешел :)');
                    }
                    $articlesCount = $pagesCountAsArray[1];
                    $articles = Article::getPageByRating($pageNum, $itemsPerPage, 'plus DESC');
                } else {
                    $orderBy = 'DESC';
                    $pagesCountAsArray = Article::getPagesCount($itemsPerPage);
                    $pagesCount =  $pagesCountAsArray[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        throw new NotFoundException('Привет! Ты куда-то не туда перешел :)');
                    }
                    $articlesCount = $pagesCountAsArray[1];
                    $articles = Article::getPage($pageNum, $itemsPerPage, 'articles.id DESC');
                }
            }

            $comments = Comment::getItemsCountByColumn($articles, 'article_id');
            
        } catch (NotFoundException $e) {
            $this->view->renderHtml('main/main.php', 
            ['error' => $e->getMessage()], 404);
            return;
        } 

        $this->view->renderHtml('main/main.php', 
                [
                    'articles' => $articles,
                    'articlesCount' => $articlesCount,
                    'comments' => $comments,
                    'previousPageLink' => $pageNum > 1 ? '/' . ($pageNum - 1) : null,
                    'nextPageLink' => $pageNum < $pagesCount ? '/' . ($pageNum + 1) : null,
                    'currentPageNum' => $pageNum,
                    'lastPage' => $pagesCount,
                    'orderBy' => $orderBy,
                    'searchPanelName' => $searchArgAsArray[0],
                    'searchPanelArgs' => $searchArgAsArray[1]    
                ]
        );
    }    
}


