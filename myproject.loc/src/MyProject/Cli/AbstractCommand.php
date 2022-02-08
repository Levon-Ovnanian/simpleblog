<?php
namespace MyProject\Cli;

use MyProject\Exceptions\CliException;
use MyProject\Services\UsersAuthService;
use MyProject\View\View;

abstract class AbstractCommand
{
    /** @var array */
    private $params;
    private $view;
    private $user;

 
    public function __construct(array $params)
    {
        $this->params = $params;
        $this->user = UsersAuthService::getUserByToken();
        $this->view = new View( __DIR__ . '/../../../templates');
        $this->view->setVar('user', $this->user);
        $this->checkParams();
    }

    abstract public function execute();

    abstract protected function checkParams();

    protected function getParam(string $paramName)
    {
        return $this->params[$paramName] ?? null;
    }

    protected function ensureParamExists(string $paramName)
    {
        if (!isset($this->params[$paramName])) {
            throw new CliException('Param with name "' . $paramName . '" is not set!');
        }
    }
}