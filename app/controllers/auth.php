<?php

use \Core\Controller as Controller;
use \Helpers\AuthController as AuthController;

/**
 * Handles User Auth Routes
 */
class Auth extends Controller
{
    /**
     * Auth Controller
     *
     * @var Controller
     */
    private $auth_controller;

    /**
     * Called before the routes method
     *
     * @return void
     */
    public function init()
    {
        $this->auth_controller = new AuthController();
    }

    /**
     * Redirects to the homepage
     *
     * @return void
     */
    public function index()
    {
        $this->redirect('/');
    }

    /**
     * POST Register route
     *
     * @param array $params
     *
     * @return void
     */
    public function register($params)
    {
        $this->assertType($params, 'POST');

        try {
            $this->auth_controller->register($params);
        } catch(\Exception $e) {
            $this->view('home/register.html', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * POST Login route
     *
     * @param array $params
     *
     * @return void
     */
    public function login($params)
    {
        $this->assertType($params, 'POST');

        try {
            $this->auth_controller->login(
                $params['username'],
                $params['password']
            );
        } catch(\Exception $e) {
            $this->view('home/login.html', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * POST route to verify a users account via email confirmation
     *
     * @param array $params
     *
     * @return void
     */
    public function verify($params)
    {
        $this->assertType($params, 'POST');

        try {
            $this->auth_controller->verifyUser(
                $params['email'],
                $params['verification_code']
            );
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * POST Logout route
     *
     * @param array $params
     *
     * @return void
     */
    public function logout($params)
    {
        $this->assertType($params, 'GET');

        $this->auth_controller->logout();
    }
}