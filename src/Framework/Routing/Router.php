<?php

namespace LPF\Framework\Routing;

use LPF\Framework\App;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;


/**
 * Application router
 */
class Router
{
    /** @var RouteCollection */
    protected $routes = null;
    protected $context = null;

    /**
     * Construct Router
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->context = new RequestContext('/');
        $this->routes = new RouteCollection();
    }

    /**
     * Define GET route
     *
     * @param string $uri
     * @param string $controllerAction
     * @param string $name
     * @return void
     */
    public function get($uri, $controllerAction, $name = 'route')
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') return; 

        $controller = explode("@", $controllerAction)[0];
        $a = explode("@", $controllerAction)[1];

        $this->routes->add($name, new Route($uri, [
            'controller' => $controller,
            'action' => $a,
            'method' => 'GET',
        ]));
    }

    /**
     * Define POST route
     *
     * @param string $uri
     * @param string $controllerAction
     * @param string $name
     * @return void
     */
    public function post($uri, $controllerAction, $name = '')
    {
        if($_SERVER['REQUEST_METHOD'] != 'POST') return; 

        $controller = explode("@", $controllerAction)[0];
        $a = explode("@", $controllerAction)[1];

        $this->routes->add($name, new Route($uri, [
            'controller' => $controller,
            'action' => $a,
            'method' => 'POST',
        ]));
    }

    /**
     * Match the route from $_SERVER['REQUEST_URI']
     *
     * @return void
     */
    public function match()
    {
        $matcher = new UrlMatcher($this->routes, $this->context);

        return $matcher->match(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
    }

    /**
     * Generate url to route
     * example: /user/{id} and route name is user
     * getURLToRoute('user', ['id' => 3]) -> /user/3
     *
     * @param string $routeName
     * @param array $params
     * @return string
     */
    public function getURLToRoute($routeName, array $params) : string
    {
        $generator = new UrlGenerator($this->routes, $this->context);

        return $generator->generate($routeName, $params);
    }
}
