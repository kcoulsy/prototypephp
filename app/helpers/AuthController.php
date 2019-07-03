<?php

class AuthController extends Controller {

    public function register($params)
    {
        try {
            if (!isset($params['username'])) {
                throw new Exception('Please enter a username');
            }

            $username = trim($params['username']);

            $user = User::where('username', $username);

            if ($user->count() > 0) {
                throw new Exception('Username Taken');
            }

            if (!isset($params['email'])) {
                throw new Exception('Please enter an Email');
            }

            $email = trim($params['email']);

            $user = User::where('email', $email);

            if ($user->count() > 0) {
                throw new Exception('Email Taken');
            }

            if (!isset($params['password'])) {
                throw new Exception('Please enter an Password');
            }

            if (!isset($params['confirm'])) {
                throw new Exception('Please confirm your Password');
            }

            if ($params['password'] !== $params['confirm']) {
                throw new Exception('Your passwords must match!');
            }

            $password = $params['password'];

            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            User::create([
                'username' => $username,
                'email' => $email,
                'password' => $password_hashed
            ]);

            $this->redirect('/');

        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function login($username, $password)
    {
        if (!isset($username)) {
            throw new Exception('Please enter a Username');
        }

        if (!isset($password)) {
            throw new Exception('Please enter an Password');
        }

        $user = User::where('username', $username)->first();

        if (!isset($user->username)) {
            throw new Exception('Failed to login');
        }

        if (password_verify($password, $user->password)) {
            $this->startSession($user);
        }
    }

    public function logout()
    {
        $this->sessionDestroy();
    }

    protected function startSession($user)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION["loggedin"] = true;
        $_SESSION["user"] = $user;

        $this->redirect('/');
    }

    protected function sessionDestroy()
    {
        $_SESSION = array();
        session_destroy();

        $this->redirect('/');
    }
}