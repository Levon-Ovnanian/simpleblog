<?php
namespace MyProject\Controllers;

use MyProject\Services\UsersAuthService;
use MyProject\View\View;

/**
 * abstract class takes responsibility for getting current session user data,
 * creates new object of class View and gives to it main path to html templates,
 * passes to method setVar() of class View current session user data for further rendering;
 * class has two properties:
 * protected $view - association with an object of class View,
 * protected $user - association with an object of class UsersAuthService;   
 */
abstract class AbstractController
{
    protected $view;
    protected $user;

    /**
     * main constructor; 
     */
    public function __construct()
    {
        $this->user = UsersAuthService::getUserByToken(); ///return current session user data;
        $this->view = new View( __DIR__ . '/../../../templates'); ///creates new object of class View, passes to it main path to html templates;
        $this->view->setVar('user', $this->user); ///passes current session user data for further rendering;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    protected function getInputData()
    {
        return json_decode(
            file_get_contents('php://input'),
            true
        );
    }
}