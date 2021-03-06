<?php

namespace Core;

use \Helpers\AuthController as AuthController;

/**
 * Core of the app, routes the controllers.
 */
class App
{
    /**
     * The selected controller name.
     *
     * @var string
     */
    private $controller = 'home';

    /**
     * The selected method name.
     *
     * @var string
     */
    private $method = 'index';

    /**
     * The selected params.
     *
     * @var array
     */
    private $params = [];

    /**
     * The request method type.
     *
     * @var string
     */
    private $type = 'GET';

    /**
     * App Constuctor.
     */
    public function __construct()
    {
        $this->updateMethod();
    }

    /**
     * Returns the parsed request as an array.
     *
     * @return array request
     */
    private function parseRequest()
    {
        if (isset($_GET['url'])) {
            $params = $_GET;

            $params['url'] = explode('/', filter_var(rtrim($params['url'], '/'), FILTER_SANITIZE_URL));

            return $params;
        }
    }

    /**
     * Updates the selected controller, method, params and type
     *
     * @return void
     */
    private function updateMethod()
    {
        $req = $this->parseRequest();
        $method = $this->method;

        // splitting out url from req
        $url = $req['url'];
        unset($req['url']);

        if (isset($url)) {
            if (count($url) > 1) {
                $controller = join('/', $url);

                // check if the whole string is the controller
                // ie, we are calling the index() method
                if (!$this->checkAndSetController($controller)) {
                    // pop off the last value and use it as a method
                    $method = end($url);
                    array_pop($url);

                    // rejoin and check for the controller
                    $controller = join('/', $url);

                    //check the new controller
                    $this->checkAndSetController($controller);
                }

            } else {
                // checking if the url string is a controller, if it is then use it,
                // else it falls back to using it as a method on Home
                $url_string = $url[0];
                if (!$this->checkAndSetController($url_string)) {
                    $method = $url_string;
                }
            }
        }

        require_once '../app/controllers/' . $this->controller . '.php';

        // Convert to \namespace\class
        $this->controller = '\\' . str_replace('/', '\\', $this->controller);

        $this->controller = new $this->controller;

        // checking that the set method exists, if it does then use it
        if (isset($method)) {
            if (method_exists($this->controller, $method)) {
                $this->method = $method;
            }
        }

        $this->type = $_SERVER['REQUEST_METHOD'];

        // setting the params nased on method type
        if ($this->type == 'POST') {
            $this->params = $_POST;
        } else {
            $this->params = $req;
        }

        $this->params['request_type'] = $this->type;

        $this->callMethod();
    }

    /**
     * Checking the the controller exists, if it does then set it.
     *
     * @param string $controller
     * @return void
     */
    private function checkAndSetController($controller) {
        if (file_exists('../app/controllers/' . $controller . '.php')) {
            $this->controller = $controller;
            return true;
        }
        return false;
    }

    /**
     * Checks role access and calls the routes method or redirects to home
     *
     * @return void
     */
    private function callMethod()
    {
        if ($this->hasAccess()) {
            call_user_func([$this->controller, $this->method], $this->params);
        } else {
            header('Location: /');
            die();
        }
    }

    /**
     * Checks whether the route is protected and whether the user has the required role.
     *
     * @return boolean
     */
    private function hasAccess()
    {
        if (isset($this->controller->protected_roles)) {
            $protected_roles = $this->controller->protected_roles;

            if (isset($protected_roles[$this->method])) {
                $required_role = $protected_roles[$this->method];
                $auth_controller = new AuthController();

                if (!$auth_controller->isLoggedIn()) {
                    return false;
                }

                return $auth_controller->hasRole($required_role);
            }

            // method not in protected roles so has access
            return true;
        };
        // controller has no protected roles so has access
        return true;
    }
}