<?php

class AuthController extends Controller {

    public function __construct()
    {

    }

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
            session_start();

            $_SESSION["loggedin"] = true;
            $_SESSION["user"] = $user;

            $this->redirect('/');
        }
    }
}