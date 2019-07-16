<?php

namespace Helpers;

use Illuminate\Database\Capsule\Manager as DB;
use \Core\Controller as Controller;
use \Model\User as User;
use \Model\UserVerification as UserVerification;

/**
 * Used for handling authorisation of a user
 */
class AuthController extends Controller {

    /**
     * Registers the user
     *
     * @param array $params
     *
     * @return void
     *
     * @throws \Exception
     */
    public function register($params)
    {
        try {
            if (!isset($params['username'])) {
                throw new \Exception('Please enter a username');
            }

            $username = trim($params['username']);

            $user = User::where('username', $username);

            if ($user->count() > 0) {
                throw new \Exception('Username Taken');
            }

            if (!isset($params['email'])) {
                throw new \Exception('Please enter an Email');
            }

            $email = trim($params['email']);

            $user = User::where('email', $email);

            if ($user->count() > 0) {
                throw new \Exception('Email Taken');
            }

            if (!isset($params['password'])) {
                throw new \Exception('Please enter an Password');
            }

            if (!isset($params['confirm'])) {
                throw new \Exception('Please confirm your Password');
            }

            if ($params['password'] !== $params['confirm']) {
                throw new \Exception('Your passwords must match!');
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
                    'name' => $created_user->username,
                    'email' => $created_user->email,
                    'verification_code' => $verification_code,
                    'base_url' => 'http://development/'
                ])
            );

            $this->redirect('/');

        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Verifys a users account via email
     *
     * @param string $email
     * @param string $verification_code
     *
     * @return void
     *
     * @throws \Exception
     */
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
                throw new \Exception('Invalid Verification Code');
            }

        } else {
            throw new \Exception('User not found');
        }
    }

    /**
     * Login the user
     *
     * @param string $username
     * @param string $password
     *
     * @return void
     *
     * @throws \Exception
     */
    public function login($username, $password)
    {
        if (!isset($username)) {
            throw new \Exception('Please enter a Username');
        }

        if (!isset($password)) {
            throw new \Exception('Please enter an Password');
        }

        $user = User::where('username', $username)->first();

        if (!isset($user->username)) {
            throw new \Exception('Failed to login');
        }

        if (password_verify($password, $user->password)) {
            if (!$user->email_verified) {
                throw new \Exception('Email not verified');
            };

            $this->startSession($user);
        } else {
            // @TODO do something
        }
    }

    /**
     * Calls session destroy
     *
     * @return void
     */
    public function logout()
    {
        $this->sessionDestroy();
    }

    /**
     * Starts a session and redirects to home
     *
     * @param Object $user
     * @return void
     */
    protected function startSession($user)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION["loggedin"] = true;
        $_SESSION["user"] = $user;

        $this->redirect('/');
    }

    /**
     * Kills existing session and redirects to home
     *
     * @return void
     */
    protected function sessionDestroy()
    {
        $_SESSION = array();
        session_destroy();

        $this->redirect('/');
    }

    /**
     * Checks if logged in
     *
     * @return bool $logged_in;
     */
    public function isLoggedIn()
    {
        if (session_status() == PHP_SESSION_NONE) {
            return false;
        }

        if (isset($_SESSION["loggedin"])) {
            return $_SESSION['loggedin'];
        }

        return false;
    }

    /**
     * Checks if logged in and returns the logged in user
     *
     * @return Model $user;
     */
    public function getUser()
    {
        if (
            session_status() == PHP_SESSION_NONE
            || !isset($_SESSION['loggedin'])
            || !$_SESSION["loggedin"]
            || !isset($_SESSION['user'])
        ) {
            return null;
        }

        return $_SESSION['user'];
    }

    /**
     * Checks whether the logged in user has the passed in role
     *
     * @param string $role
     *
     * @return bool $has_role
     */
    public function hasRole($role)
    {
        if (
            session_status() == PHP_SESSION_NONE
            || !isset($_SESSION['loggedin'])
            || !$_SESSION["loggedin"]
            || !isset($_SESSION['user'])
        ) {
            return false;
        }

        $user = $_SESSION['user'];

        $user_roles = DB::table('role')
                        ->join('group_roles', 'role.id', '=', 'group_roles.role_id')
                        ->join('user_group_link', function($join) use ($user) {
                            $join->on('user_group_link.group_id', '=','group_roles.group_id')
                                ->where('user_group_link.user_id', '=', $user->id);
                        })
                        ->where('role.alias', '=', $role)
                        ->get();

        return $user_roles->count() > 0;
    }

    /**
     * Checks whether the logged in user for the array or roles passes, returning each as a bool
     *
     * @param array $roles
     *
     * @return array $has_roles
     */
    public function hasRoles($roles)
    {
        if (
            session_status() == PHP_SESSION_NONE
            || !isset($_SESSION['loggedin'])
            || !$_SESSION["loggedin"]
            || !isset($_SESSION['user'])
        ) {
            return false;
        }

        $user = $_SESSION['user'];

        $user_roles = DB::table('role')
                        ->join('group_roles', 'role.id', '=', 'group_roles.role_id')
                        ->join('user_group_link', function($join) use ($user) {
                            $join->on('user_group_link.group_id', '=','group_roles.group_id')
                                ->where('user_group_link.user_id', '=', $user->id);
                        })
                        ->whereIn('alias', $roles)
                        ->pluck('alias')
                        ->toArray();

        $has_roles = [];

        foreach($roles as $role) {
            $has_roles[$role] = false;
        }

        foreach($user_roles as $role) {
            $has_roles[$role] = true;
        }

        return $has_roles;
    }
}