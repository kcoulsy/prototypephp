<?php

class Auth extends Controller
{
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
        $username = $this->validateUsername($params);
        $email = $this->validateEmail($params);
        $password = $this->validatePassword($params);

        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        User::create([
            'username' => $username,
            'email' => $email,
            'password' => $password_hashed
        ]);

        $this->redirect('/');
    }

    private function validateUsername($params)
    {
        if (!isset($params['username'])) {
            throw new Error('Please enter a username');
        }

        $username = trim($params['username']);

        $user = User::where('username', $username);

        if ($user->count() > 0) {
            throw new Error('Username Taken');
        }

        return $username;
    }

    private function validateEmail($params)
    {
        if (!isset($params['email'])) {
            throw new Error('Please enter an Email');
        }

        $email = trim($params['email']);

        $user = User::where('email', $email);

        if ($user->count() > 0) {
            throw new Error('Email Taken');
        }

        return $email;
    }

    private function validatePassword($params)
    {
        if (!isset($params['password'])) {
            throw new Error('Please enter an Password');
        }

        if (!isset($params['confirm'])) {
            throw new Error('Please confirm your Password');
        }

        if ($params['password'] !== $params['confirm']) {
            throw new Error('Your passwords must match!');
        }

        return $params['password'];
    }

    public function login($params)
    {
        if (!isset($params['username'])) {
            throw new Error('Please enter a username');
        }

        if (!isset($params['password'])) {
            throw new Error('Please enter an Password');
        }

        $user = User::where('username', $params['username'])->first();

        if (!isset($user->username)) {
            throw new Error('Failed to login');
        }

        if (password_verify($params['password'], $user->password)) {
            session_start();

            $_SESSION["loggedin"] = true;
            $_SESSION["user"] = $user;

            $this->redirect('/');
        }
    }

    public function logout()
    {
        $_SESSION = array();
        session_destroy();
        $this->redirect('/');
    }
}