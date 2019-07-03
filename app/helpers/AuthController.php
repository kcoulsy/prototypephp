<?php

class AuthController extends Controller {

    public function login($username, $password)
    {
        if (!isset($username)) {
            throw new Exception('Please enter a username');
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