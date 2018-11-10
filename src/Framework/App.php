<?php

namespace LPF\Framework;

use LPF\Framework\Database\DBConnectionInterface;
use LPF\Framework\Template\TemplateInterface;
use LPF\Framework\Auth\Auth;
use LPF\Framework\Routing\Router;
use LPF\Framework\Filesystem\StorageInterface;

class App
{
    /**
     * @var ActionDispatcher
     */
    protected $actionDispatcher = null;

    /** @var \LPF\Database\DBConnectionInterface */
    protected $connection = null;

    /** @var \LPF\Template\TemplateInterface */
    protected $template = null;

    /** @var Auth */
    protected $auth = null;

    /** @var Router */
    protected $router = null;

    /** @var StorageInterface */
    protected $storage = null;

    protected $config = [];

    /**
     * Loa application config
     *
     * @return void
     */
    private function loadConfig()
    {
        $this->config = require __DIR__ . '/../App/config.php';
    }

    /**
     * Create application and dispatch response
     *
     * @return void
     */
    public function create()
    {
        $this->loadConfig();

        // get controller and action (deprecated)
        $defaultAction = explode("@", $this->getConfig("app")['default_action']);
        $ctrl = isset($_GET['controller']) ? $_GET['controller'] : $defaultAction[0];
        $action = isset($_GET['action']) ? $_GET['action'] : $defaultAction[1];

        // create all dependencies
        $this->boot();

        // load routes
        $router = $this->getRouter();
        include __DIR__ . '/../App/routes.php';

        // get matching route
        $route = $this->getRouter()->match();

        $ctrl = $route['controller'];
        $action = $route['action'];

        // create action dispatcher
        $this->actionDispatcher = new ActionDispatcher(
            $this,
            $ctrl,
            $action,
            $route
        );

        // dispatch
        $this->actionDispatcher->dispatch();
    }

    /**
     * Setup dependencies
     *
     * @return void
     */
    public function boot()
    {
        // create database connection
        $dbDriver = $this->getConfig('database')['driver'];
        $this->connection = new $dbDriver($this->getConfig('database'));

        // create template engine
        $templateDriver = $this->getConfig('template')['driver'];
        $this->template = new $templateDriver($this->getConfig('template'));

        // create auth 
        $this->auth = new Auth($this);

        // router
        $this->router = new Router($this);

        // storage
        $storageDriver = $this->getConfig('filesystem')['driver'];
        $this->storage = new $storageDriver($this->getConfig('filesystem'));
    }

    /**
     * Return storage
     *
     * @return StorageInterface
     */
    public function getStorage() : StorageInterface
    {
        return $this->storage;
    }

    /**
     * Returns router
     *
     * @return Router
     */
    public function getRouter() : Router
    {
        return $this->router;
    }

    /**
     * Return auth
     *
     * @return Auth
     */
    public function getAuth() : Auth
    {
        return $this->auth;
    }

    /**
     * Return database connection
     *
     * @return DBConnectionInterface
     */
    public function getConnection(): DBConnectionInterface
    {
        return $this->connection;
    }

    /**
     * Return template engine
     *
     * @return TemplateInterface
     */
    public function getTemplate(): TemplateInterface
    {
        return $this->template;
    }

    /**
     * Get value from config
     *
     * @param string $root
     * @return void
     */
    public function getConfig($root)
    {
        return isset($this->config[$root]) ? $this->config[$root] : null;
    }
}
