<?php

namespace LPF\Framework;

use LPF\Framework\Http\Request;

class ActionDispatcher
{
    protected $controller = null;
    protected $action = null;
    protected $data = [];

    /** @var App */
    protected $app = null;

    /**
     * Construct ActionDispatcher
     *
     * @param App $app
     * @param string $controller
     * @param string $action
     */
    public function __construct(App $app, $controller, $action, $data = [])
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->app = $app;
        $this->data = $data;
    }

    /**
     * Create controller and dispatch action
     * then respond with Response
     *
     * @return void
     */
    public function dispatch()
    {
        $controller_class = "LPF\\App\\Controllers\\" . $this->controller . "Controller";

        if (!class_exists($controller_class)) {
            die("Controller '$controller_class' does not exist!");
        }

        // create controller
        $ctrl = new $controller_class($this->app); // and pass app reference
        $ctrl->setApp($this->app);

        if (!method_exists($ctrl, $this->action)) {
            die("Action '$this->action' does not exist!");
        }

        // create request
        $request = new Request;
        $request->createFromGlobals();
        $request->setApp($this->app);
        $request->addData($this->data);

        // dispatch action
        $action = $this->action;
        $response = $ctrl->{$action}($request);

        // respond
        if ($response != null) {
            $response->respond();
        } else {
            die("<b>Controller's action returned wrong response.</b>");
        }
    }
}
