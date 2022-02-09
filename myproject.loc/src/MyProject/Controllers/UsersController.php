<?php
namespace MyProject\Controllers;

use MyProject\Exceptions\ActivationException;
use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Exceptions\UploadException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;
use MyProject\Models\Followers\Followers;
use MyProject\Models\Users\User;
use MyProject\Services\UserActivationService;
use MyProject\Services\UsersAuthService;
use MyProject\Services\EmailSender;
use MyProject\Services\Uploads;

class UsersController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function signUp(): void
    {
        if (!empty($_POST)) {
            try{
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }
             
            if ($user instanceof User) {
                $code = UserActivationService::createActivationCode($user);     
                EmailSender::send($user, 'Активация', 'userActivation.php', 
                    [
                        'userId' => $user->getId(),
                        'code' => $code
                    ]
                ); 
                $this->view->renderHtml('users/signUpSuccessful.php');
                return;
            }                     
        }
        $this->view->renderHtml('users/signUp.php');
    }

    /**
     * Undocumented function
     *
     * @param integer $userId
     * @param string $activationCode
     * @return void
     */
    public function activate(int $userId, string $activationCode): void
    {
        try{
            $user = User::getById($userId);
            if ($user === null) {
                throw new ActivationException('Пользователь не найден'); 
            }
            if ($user->getIsConfirmed() === 1) {
                throw new ActivationException('Пользователь уже активирован'); 
            }
        
            $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
            if ($isCodeValid === null) {
                throw new ActivationException('Неправильный код активации');
            }

            $user->activation();
            UserActivationService::deleteActivationCode($user, $activationCode);    
            $this->view->renderHtml('users/login.php', ['info' => 'Активация успешна! Авторизуйтесь']);
            return;
        } catch(ActivationException $e) {
            $this->view->renderHtml('errors/401.php', ['error' => $e->getMessage()], 401);
        }
    }
 
    /**
     * Undocumented function
     *
     * @return void
     */
    public function login(): void
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);       
                header('Location: /users/cabinet/personalpage');    
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('users/login.php');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function logout(): void
    {
       if ($this->user instanceof User) {
           UsersAuthService::deleteToken($this->user);
           header('Location: /');
           exit();
       } 
       header('Location: /');
       exit();
    }

    /**
     * Undocumented function
     *
     * @param integer $userId
     * @return void
     */
    public function userPage(int $userId): void
    {
        try{
            $author = User::getById($userId);
            if ($author === null) {
                throw new NotFoundException('Пользователь не найден');
            }
            
            $articles = Article::findAllByColumnDESC('author_id', $userId);
            if ($articles === null) {
                throw new NotFoundException('Привет! К сожалению, у автора еще нет статей! :(');
            }

            $articlesCount = Article::getArticlesCountForUser($userId, 'author_id');
            $orderBy = $_POST['orderBy'];

            if ($orderBy === 'ASC') {
                
                $articles = Article::findAllByColumnASC('author_id', $userId);
            }

            if ($orderBy === 'withComments') {
                $articles = Article::getArticlesWithCommentsForUser($userId, 'DESC');
                if ($articles === null) {
                    throw new NotFoundException('Привет! К сожалению, у автора еще нет статей c комментариями! :(');
                }
                $articlesCount = Article::getArticlesWithCommentsCountForUser($userId);
            }

            if ($orderBy === 'withCommentsASC') {
                $articles = Article::getArticlesWithCommentsForUser($userId, 'ASC');
                if ($articles === null) {
                    throw new NotFoundException('Привет! К сожалению, у автора еще нет статей c комментариями! :(');
                }
                $articlesCount = Article::getArticlesWithCommentsCountForUser($userId);
            }

            if ($articles !== null AND $this->user) {
                if ($follower = Followers::findFollowerData($this->user)) {
                    $isAlreadyFollowed = $follower->compareWithArray($articles[0]->getAuthorId()->getEmail(), $follower->getAuthorEmail());
                }
            }
            $commentsCountForArticles = Comment::getItemsCountByColumn($articles, 'article_id');
            $getCommentsCount = Comment::getItemsCountByColumn([$author], 'user_id');
        
        } catch (NotFoundException $e) {
            $this->view->renderHtml('users/userPage.php', 
                [
                    'author' => $author,
                    'follower' => $follower,
                    'articles' => $articles,
                    'error' => $e->getMessage(),
                    'isAlreadyFollowed' => $isAlreadyFollowed,
                    'commentsCountForArticles' => $commentsCountForArticles,
                    'commentsCountAll' => $getCommentsCount
                ],
                404
            );     
            return;    
        }
        
        $this->view->renderHtml('users/userPage.php', 
                [
                    'author' => $author,
                    'follower' => $follower,
                    'articles' => $articles,
                    'commentsCountForArticles' => $commentsCountForArticles,
                    'commentsCountAll' => $getCommentsCount,
                    'isAlreadyFollowed' => $isAlreadyFollowed,
                    'articlesCount' => $articlesCount,
                    'orderBy' => $orderBy
                ]
        );   
    }

    /**
     * Undocumented function
     *
     * @param string $filterData
     * @return void
     */
    public function usersManager(string $filterData): void
    { 
        try{
            
            if ($this->user === null) {
                throw new ForbiddenException('Авторизуйтесь как администратор');
            }
            if ($this->user->isAdmin() === false) {
                throw new ForbiddenException('Авторизуйтесь как администратор'); 
            }
             
            if ($_POST['filteredUserManager']) {
                $filteredUserManager = $_POST['filteredUserManager'];
            } else { 
                $filteredUserManager = $filterData;
            }
            
            if ($_POST['filteredByUserNameUserManager']) {
                $usersManaged = User::findUsersByNameDESC($_POST['filteredByUserNameUserManager']);
            } 
            elseif ($filteredUserManager === 'date/DESC') {
                $usersManaged = User::findAllWithOptionalColumnOrder('created_at', 'DESC');
            }
            elseif ($filteredUserManager === 'date/ASC') {
                $usersManaged = User::findAllWithOptionalColumnOrder('created_at', 'ASC');
            }
            elseif ($filteredUserManager === 'A-Z/DESC') {
                $usersManaged = User::findAllWithOptionalColumnOrder('nickname', 'ASC');
            }
            elseif ($filteredUserManager === 'Z-A/ASC') {
                $usersManaged = User::findAllWithOptionalColumnOrder('nickname', 'DESC');
            }
            elseif ($filteredUserManager === 'active') {
                $usersManaged = User::findAllByColumnDESC('status', 'active');
            }
            elseif ($filteredUserManager === 'limited') {
                $usersManaged = User::findAllByColumnDESC('status', 'limited');
            }
            elseif ($filteredUserManager === 'blocked') {
                $usersManaged = User::findAllByColumnDESC('status', 'blocked');
            }
            elseif ($filteredUserManager === 'admin') {
                $usersManaged = User::findAllByColumnDESC('role', 'admin');
            }
            elseif ($filteredUserManager === 'user') {
                $usersManaged = User::findAllByColumnDESC('role', 'user');
            } else {
                $filteredUserManager = 'date/DESC';
                $usersManaged = User::findAllWithOptionalColumnOrder('created_at', 'DESC');
            }  

            if ($usersManaged === null) {
                throw new NotFoundException('Пользователи по выборке не найдены');
            }    
            
        } catch (NotFoundException $e) {
            $this->view->renderHtml('users/usersManager.php', 
                [
                'error' => $e->getMessage(),
                'filteredUserManager' => $filteredUserManager,
                'user' => $this->user
                ],
                404
            );
            return; 
        } catch (ForbiddenException $e) {
            $this->view->renderHtml('errors/401.php', ['error' => $e->getMessage(), 'user' => $this->user], 401);
            return;
        }

        $subscribeData = Followers::getSubscribeDataForMultipleUsers($usersManaged);
        $userSubscribed = User::findAllAsArrayByColumn('email', $subscribeData);
        $followersData = Followers::getFollowersDataForMultipleUsers($usersManaged);
        $articlesCount = Article::getItemsCountByColumn($usersManaged, 'author_id');
        $commentsCount = Comment::getItemsCountByColumn($usersManaged, 'user_id');
        
        $this->view->renderHtml('users/usersManager.php', 
            [
                'users' => $usersManaged,
                'subscribes' =>  $userSubscribed,
                'followers' => $followersData,
                'articlesCount' => $articlesCount,
                'commentsCount' => $commentsCount,
                'filteredUserManager' => $filteredUserManager
            ] 
        );
    }

    /**
     * Undocumented function
     *
     * @param integer $userId
     * @return void
     */
    public function usersManagerPersonalPage(int $userId): void
    { 
        try{
            if ($this->user === null) {
                throw new ForbiddenException('Авторизуйтесь как администратор');
            }
            if ($this->user->isAdmin() === false) {
                throw new ForbiddenException('Авторизуйтесь как администратор'); 
            }
            
            $userManaged = User::getById($userId);
            if ($userManaged === null) {
                throw new NotFoundException('Пользователь не найден');
            }

            if ($_POST['role'] AND $_POST['role'] === 'user' OR $_POST['role'] === 'admin') {
                
                $userManaged->setRole($_POST['role']);
                $userManaged->setEmailSendIfArticle((int)$_POST['EmailSendIfArticle']);       
                $userManaged->setEmailSendIfComment((int)$_POST['EmailSendIfComment']);
                $userManaged->setEmailSendIfAddFollower((int)$_POST['EmailSendIfAddFollower']);   
                $userManaged->setEmailSendIfDellFollower((int)$_POST['EmailSendIfDellFollower']); 
                if ($_POST['status'] === 'active' OR $_POST['status'] === 'limited' OR $_POST['status'] === 'blocked') {
                    $userManaged->setStatus($_POST['status']);
                } else {
                    $_POST['status'] = $userManaged->getStatus();
                }
                $userManaged->save();
                
                $formOptionData = 
                    [
                        $_POST['role'],
                        $_POST['status'],
                        (int)$_POST['EmailSendIfArticle'], 
                        (int)$_POST['EmailSendIfComment'],
                        (int)$_POST['EmailSendIfAddFollower'], 
                        (int)$_POST['EmailSendIfDellFollower'],     
                        $userId
                    ];                      
            } 

            $subscribeData = Followers::getSubscribeDataForMultipleUsers([$userManaged]);
            $userSubscribed = User::findAllAsArrayByColumn('email', $subscribeData);
            $followersData = Followers::getFollowersDataForMultipleUsers([$userManaged]);
            $articlesCount = Article::getItemsCountByColumn([$userManaged], 'author_id');
            $commentsCount = Comment::getItemsCountByColumn([$userManaged], 'user_id');
            
        } catch (NotFoundException $e) {
            $this->view->renderHtml('errors/404.php', ['error' => $e->getMessage(), 'user' => $this->user], 404);
            return; 
        } catch (ForbiddenException $e) {
            $this->view->renderHtml('errors/401.php', ['error' => $e->getMessage(), 'user' => $this->user], 401);
            return;
        }

        $this->view->renderHtml('users/usersManagerPersonal.php', 
            [
                'userManaged' => $userManaged,
                'subscribes' =>  $userSubscribed,
                'followers' => $followersData,
                'articlesCount' => $articlesCount,
                'commentsCount' => $commentsCount,
                'formOptionData' => $formOptionData
            ] 
        );
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function adminPanelMain(): void
    {   
        $this->adminPanelPagesViewer(1, 'DESC', 'null/null');
    }

    /**
     * Undocumented function
     *
     * @param string $pageNum
     * @param string $articlesOrder
     * @param string $searchArgs
     * @return void
     */
    public function adminPanelPagesViewer(string $pageNum, string $articlesOrder, string $searchArgs): void
    {    
        try {
            if ($this->user === null) {
                throw new ForbiddenException('Авторизуйтесь как администратор');
            }
            if ($this->user->isAdmin() === false) {
                throw new ForbiddenException('Авторизуйтесь как администратор'); 
            }

            $checkForArticles = Article::findAll();
            if ($checkForArticles === []) {
                throw new NotFoundException('Статей пока нет');
            }
    
            $itemsPerPage = 5;
            
            $orderBy = $_POST['orderBy'] ? $_POST['orderBy'] : $articlesOrder;
            $searchArgAsArray = $_POST['mainSearchPanelArguments'] ? [$_POST['mainSearchPanel'], $_POST['mainSearchPanelArguments']]: $searchArgs = explode('/', $searchArgs);

            if ($searchArgAsArray[0] !== 'name' || $searchArgAsArray[0] !== 'text' || $searchArgAsArray[0] !== 'nickname') {
                $searchArgAsArray[0] ='null';
            }
            
            if ($searchArgAsArray[0] !== 'null') {
            
                if ($orderBy === 'ASC') { 
                    $pagesAndArticlesCounter = Article::getPagesCountWithSearchArgs($itemsPerPage, $searchArgAsArray);
                    $articlesCount = $pagesAndArticlesCounter[1];
                    if ($articlesCount == false) {
                        throw new NotFoundException('Статей с такой выборкой нет');
                    }
                    $pagesCount = $pagesAndArticlesCounter[0];
                    if ((int)$pageNum > (int)$pagesCount || (int)$pageNum <= 0) {
                        $pageNum = $pagesCount;
                    }
                    $articles = Article::getPageWithSearchArgsASC($pageNum, $itemsPerPage, $searchArgAsArray);
                    $getCommentsCount = Comment::getCommentsCount($itemsPerPage, $searchArgAsArray);
                    $commentsCount = $getCommentsCount[1];
                }    
                elseif ($orderBy === 'DESC') {  
                    $pagesAndArticlesCounter = Article::getPagesCountWithSearchArgs($itemsPerPage, $searchArgAsArray);
                    $articlesCount = $pagesAndArticlesCounter[1];
                    if ($articlesCount == false) {
                        throw new NotFoundException('Статей с такой выборкой нет');
                    }
                    $pagesCount = $pagesAndArticlesCounter[0];
                    if ((int)$pageNum > (int)$pagesCount || (int)$pageNum <= 0) {
                        $pageNum = $pagesCount;
                    }
                    $articles = Article::getPageWithSearchArgs($pageNum, $itemsPerPage, $searchArgAsArray);
                    $getCommentsCount = Comment::getCommentsCount($itemsPerPage, $searchArgAsArray);
                    $commentsCount = $getCommentsCount[1];
                }       
                elseif ($orderBy === 'withComments') {
                    $pagesAndArticlesCounter = Article::getPagesWithCommentsCount($itemsPerPage, $searchArgAsArray);
                    $articlesCount = $pagesAndArticlesCounter[1];
                    if ($articlesCount == false) {
                        throw new NotFoundException('Статей с такой выборкой нет');
                    }
                    $pagesCount = $pagesAndArticlesCounter[0];
                    if ((int)$pageNum > (int)$pagesCount || (int)$pageNum <= 0) {
                        $pageNum = $pagesCount;
                    }
                    $articles = Article::getArticlesWithCommentsBySearchArgsLimited($pageNum, $itemsPerPage, $searchArgAsArray);
                    $getCommentsCount = Comment::getCommentsCount($itemsPerPage, $searchArgAsArray);
                    $commentsCount = $getCommentsCount[1];
                }
                elseif ($orderBy === 'withCommentsASC') {
                    $pagesAndArticlesCounter = Article::getPagesWithCommentsCount($itemsPerPage, $searchArgAsArray);
                    $articlesCount = $pagesAndArticlesCounter[1];
                    if ($articlesCount == false) {
                        throw new NotFoundException('Статей с такой выборкой нет');
                    }
                    $pagesCount = $pagesAndArticlesCounter[0];
                    if ((int)$pageNum > (int)$pagesCount || (int)$pageNum <= 0) {
                        $pageNum = $pagesCount;
                    }
                    $articles = Article::getArticlesWithCommentsBySearchArgsLimitedASC($pageNum, $itemsPerPage, $searchArgAsArray);
                    $getCommentsCount = Comment::getCommentsCount($itemsPerPage, $searchArgAsArray);
                    $commentsCount = $getCommentsCount[1];
                } 
                elseif ($orderBy === 'ratingDESC') {
                    $pagesCountAsArray = Article::getPagesCountWithSearchArgs($itemsPerPage, $searchArgAsArray, 'ratingDESC');
                    $articlesCount = $pagesCountAsArray[1];
                    if ($articlesCount == false) {
                        throw new NotFoundException('Привет! К сожалению, у нас нет статей c таким фильтром!');
                    }
                    $pagesCount = $pagesCountAsArray[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        $pageNum = $pagesCount;
                    }
                    $articles = Article::getPageWithSearchArgs($pageNum, $itemsPerPage, $searchArgAsArray, 'plus DESC', 'ratingDESC');
                } else {
                    $orderBy ='DESC';  
                    $pagesAndArticlesCounter = Article::getPagesCountWithSearchArgs($itemsPerPage, $searchArgAsArray);
                    $articlesCount = $pagesAndArticlesCounter[1];
                    if ($articlesCount == false) {
                        throw new NotFoundException('Статей с такой выборкой нет');
                    }
                    $pagesCount = $pagesAndArticlesCounter[0];
                    if ((int)$pageNum > (int)$pagesCount || (int)$pageNum <= 0) {
                        $pageNum = $pagesCount;
                    }
                    $articles = Article::getPageWithSearchArgs($pageNum, $itemsPerPage, $searchArgAsArray);
                }

            } else {

                if ($orderBy === 'ASC') { 
                    $pagesAndArticlesCounter = Article::getPagesCount($itemsPerPage);
                    $pagesCount = $pagesAndArticlesCounter[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        $pageNum = $pagesCount;
                    }
                    $articlesCount = $pagesAndArticlesCounter[1];
                    $articles = Article::getPageASC($pageNum, $itemsPerPage, 'articles.id ASC');
                    $getCommentsCount = Comment::getCommentsCount($itemsPerPage);
                    $commentsCount = $getCommentsCount[1];
                }    
                elseif ($orderBy === 'DESC') {  
                    $pagesAndArticlesCounter = Article::getPagesCount($itemsPerPage);
                    $pagesCount = $pagesAndArticlesCounter[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        $pageNum = $pagesCount;
                    }
                    $articlesCount = $pagesAndArticlesCounter[1];
                    $articles = Article::getPage($pageNum, $itemsPerPage, 'articles.id DESC');
                    $getCommentsCount = Comment::getCommentsCount($itemsPerPage);
                    $commentsCount = $getCommentsCount[1];
                }       
                elseif ($orderBy === 'withComments') {
                    $pagesAndArticlesCounter = Article::getPagesWithCommentsCount($itemsPerPage);
                    $pagesCount = $pagesAndArticlesCounter[0];
                    if ($pagesCount == false) {
                        throw new NotFoundException('Статей с комментариями пока нет');
                    }
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        $pageNum = $pagesCount;
                    }
                    $articlesCount = $pagesAndArticlesCounter[1];
                    $articles = Article::getArticlesWithCommentsLimited($pageNum, $itemsPerPage, 'DESC');
                    $getCommentsCount = Comment::getCommentsCount($itemsPerPage);
                    $commentsCount = $getCommentsCount[1];
                }
                elseif ($orderBy === 'withCommentsASC') {
                    $pagesAndArticlesCounter = Article::getPagesWithCommentsCount($itemsPerPage);
                    $pagesCount = $pagesAndArticlesCounter[0];
                    if ($pagesCount == false) {
                        throw new NotFoundException('Статей с комментариями пока нет');
                    }
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        $pageNum = $pagesCount;
                    }
                    $articlesCount = $pagesAndArticlesCounter[1];
                    $articles = Article::getArticlesWithCommentsASCLimited($pageNum, $itemsPerPage, 'ASC');
                    $getCommentsCount = Comment::getCommentsCount($itemsPerPage);
                    $commentsCount = $getCommentsCount[1];
                }    
                elseif ($orderBy === 'ratingDESC') {                  
                    $pagesCountAsArray = Article::getPagesCount($itemsPerPage, 'ratingDESC');
                    $articlesCount = $pagesCountAsArray[1];
                    if ($articlesCount == false) {
                        throw new NotFoundException('Привет! К сожалению, у нас еще нет статей c таким фильтром');
                    }
                    $pagesCount =  $pagesCountAsArray[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        $pageNum = $pagesCount;
                    }
                    $articles = Article::getPageByRating($pageNum, $itemsPerPage, 'plus DESC');    
                } else {
                    $orderBy = 'DESC'; 
                    $pagesAndArticlesCounter = Article::getPagesCount($itemsPerPage);
                    $pagesCount = $pagesAndArticlesCounter[0];
                    if ($pageNum > $pagesCount || $pageNum <= 0) {
                        $pageNum = $pagesCount;
                    }
                    $articlesCount = $pagesAndArticlesCounter[1];
                    $articles = Article::getPage($pageNum, $itemsPerPage, 'articles.id DESC');
                    $getCommentsCount = Comment::getCommentsCount($itemsPerPage);
                    $commentsCount = $getCommentsCount[1];
                }
            }

            $comments = Comment::getCommentsArrayForAdminPanel($articles);
        

        } catch (NotFoundException $e) {
            $this->view->renderHtml('users/adminPanel.php', ['error' => $e->getMessage(), 'user' => $this->user], 404);
            return;
        } catch (ForbiddenException $e) {
            $this->view->renderHtml('errors/401.php', ['error' => $e->getMessage(), 'user' => $this->user], 401);
            return;
        }

        $this->view->renderHtml('users/adminPanel.php', 
            [
                'articles' => $articles,
                'previousPageLink' => $pageNum > 1 ? ($pageNum - 1) : null,
                'nextPageLink' => $pageNum <  $pagesCount ? ($pageNum + 1) : null,
                'currentPageNum' => (int)$pageNum,
                'lastPage' => (int)$pagesCount,
                'comments' => $comments,
                'articlesCount' =>  $articlesCount,
                'commentsCount' => $commentsCount,
                'orderBy' => $orderBy,
                'searchPanelName' => $searchArgAsArray[0],
                'searchPanelArgs' => $searchArgAsArray[1]  
            ]
        );

        return;    
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function userPersonalCabinet(): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (isset($_POST['EmailSendIfArticle'])) {
            $this->user->setEmailSendIfArticle((int)$_POST['EmailSendIfArticle']);       
            $this->user->setEmailSendIfComment((int)$_POST['EmailSendIfComment']);
            $this->user->setEmailSendIfAddFollower((int)$_POST['EmailSendIfAddFollower']);   
            $this->user->setEmailSendIfDellFollower((int)$_POST['EmailSendIfDellFollower']);    
    
            $this->user->save();
        }

        $subscribeData = Followers::getSubscribeDataForMultipleUsers([$this->user]);
        $userSubscribed = User::findAllAsArrayByColumn('email', $subscribeData);
        $followersData = Followers::getFollowersDataForMultipleUsers([$this->user]);
        $articlesCount = Article::getItemsCountByColumn([$this->user], 'author_id');
        $commentsCount = Comment::getItemsCountByColumn([$this->user], 'user_id');

        try {
            if (!empty($_FILES['attachment'])) {
                $user = $this->user;
                $filePath = Uploads::UploadIcon($_FILES, $user);
                $user->setIconPath($filePath);
                $user->save();
            }
        } catch (UploadException $e) {
            $this->view->renderHtml('users/personalCabinet.php', ['error' => $e->getMessage()]);
            return;
        }

        $this->view->renderHtml('users/personalCabinet.php', 
            [
                'filePath' => $filePath,
                'subscribes' => $userSubscribed,
                'followers' => $followersData,
                'articlesCount' => $articlesCount,
                'commentsCount' => $commentsCount
            ]
        );
    }
}
