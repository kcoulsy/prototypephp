<?php

// use AuthController;

class Auth extends Controller
{
    private $auth_controller;

    public function init()
    {
        $this->auth_controller = new AuthController();
    }

    /**
     * Redirects to the homepage
     */
    public function index()
    {
        $this->redirect('/');
    }

    /**
     * POST Register route
     */
    public function register($params)
    {
        $this->assertType($params, 'POST');

        try {
            $this->auth_controller->register($params);
        } catch(Exception $e) {
            $this->view('home/register.html', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * POST Login route - creates session
     */
    public function login($params)
    {
        $this->assertType($params, 'POST');

        try {
            $this->auth_controller->login(
                $params['username'],
                $params['password']
            );
        } catch(Exception $e) {
            $this->view('home/login.html', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * POST route to verify a users account via email confirmation
     */
    public function verify($params)
    {
        $this->assertType($params, 'POST');

        try {
            $this->auth_controller->verifyUser(
                $params['email'],
                $params['verification_code']
            );
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * POST Logout route - kills session
     */
    public function logout($params)
    {
        $this->assertType($params, 'GET');

        $this->auth_controller->logout();
    }
}