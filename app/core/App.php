<?php

class App
{
    /**
     * The selected controller name.
     *
     * @var string
     */
    protected $controller = 'home';

    /**
     * The selected method name.
     *
     * @var string
     */
    protected $method = 'index';

    /**
     * The selected params.
     *
     * @var array
     */
    protected $params = [];

    /**
     * The request method type.
     *
     * @var string
     */
    protected $type = 'GET';

    /**
     * App Constuctor.
     */
    public function __construct()
    {
        $this->updateMethod();
    }

    /**
     * Returns the parsed url as an array.
     *
     * @return array url
     */
    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }

    /**
     * Updates the selected controller, method, params and type.
     */
    public function updateMethod()
    {
        $url = $this->parseUrl();

        // Setting the controller
        if (file_exists('../app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->controller . '.php';

        $this->controller = new $this->controller;

        // setting the method
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->type = $_SERVER['REQUEST_METHOD'];

        // setting the params and call the controller/method
        if ($this->type == 'POST') {
            $this->params = $_POST;
        } else {
            $this->params = $url ? array_values($url) : [];
        }

        $this->callMethod();
    }

    /**
     * Calls the controller and method for the selected values.
     */
    public function callMethod()
    {
        if ($this->type == 'POST') {
            call_user_func([$this->controller, $this->method], $this->params);
        } else {
            call_user_func_array([$this->controller, $this->method], $this->params);
        }
    }
}