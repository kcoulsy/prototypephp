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
        try {
            $this->auth_controller->register($params);
        } catch(Exception $e) {
            $this->view('home/register.html', [
                'error' => $e->getMessage()
            ]);
        }
    }

    public function login($params)
    {
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

    public function logout()
    {
        $this->auth_controller->logout();
    }
}