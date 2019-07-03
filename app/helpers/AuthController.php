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

            $created_user = User::create([
                'username' => $username,
                'email' => $email,
                'password' => $password_hashed,
                'email_verified' => false
            ]);

            $verification_code = uniqid();

            UserVerification::create([
                'user_id' => $created_user->id,
                'verification_code' => $verification_code
            ]);

            $email_con = new EmailController();

            $email_sent = $email_con->send(
                [$created_user->email => $created_user->username],
                'Verify your account',
                $this->twig->render('email/verify_account.html', [
                    'email' => $created_user->email,
                    'verification_code' => $verification_code
                ])
            );

            $this->redirect('/');

        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function verifyUser($email, $verification_code)
    {
        $user = User::where('email', $email);

        if ($user->count() > 0) {

            $user = $user->first();
            $user_ver = $user->userVerification->where('verification_code', $verification_code);

            if ($user_ver->count() > 0) {
                $user->email_verified = true;
                $user->save();
                $user_ver->first()->delete();

                $this->redirect('/');
            } else {
                throw new Exception('Invalid Verification Code');
            }

        } else {
            throw new Exception('User not found');
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
            if (!$user->email_verified) {
                throw new Exception('Email not verified');
            };

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