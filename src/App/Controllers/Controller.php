<?php

namespace LPF\App\Controllers;

use LPF\Framework\App;
use LPF\Framework\Http\Response;
use LPF\Framework\Utils\Link;

/**
 * Use this Controller class to extend other controllers.
 */
abstract class Controller
{
    /** @var App */
    protected $app = null;

    /**
     * Create redirect response to controller's action
     *
     * @param string $controller
     * @param string $action
     * @param array $data
     * @return Response
     */
    public function redirect($route, $data = [])
    {
        return Response::redirect(Link::toRoute($route, $data));
    }

    /**
     * Return plain html response
     *
     * @param string $body
     * @param integer $code
     * @return Response
     */
    public function html($body, $code = 200)
    {
        return new Response($body, $code);
    }

    /**
     * Return json response
     *
     * @param array $data
     * @param integer $code
     * @return Response
     */
    public function json(array $data, $code = 200)
    {
        return new Response($data, $code);
    }

    /**
     * Return response with template
     *
     * @param string $name
     * @param array $data
     * @return Response
     */
    protected function template($name, $data = []): Response
    {
        $appData = [];

        // set auth to true or false, depending if use is signed in
        $appData['auth'] = $this->app->getAuth()->check();

        // if user is signed in set user details to auth_user
        if($appData['auth']) {
            $appData['auth_user'] = $this->app->getAuth()->user();
        }

        return new Response($this->getApp()->getTemplate()->render($name, array_merge($data, $appData)));
    }

    /**
     * Set application
     *
     * @param App $app
     * @return void
     */
    public function setApp(App $app)
    {
        $this->app = $app;
    }

    /**
     * Get app
     *
     * @return App
     */
    public function getApp(): App
    {
        return $this->app;
    }
}
