<?php

class Home extends Controller
{
    /**
     * Required roles for specific routes
     */
    public $protected_roles = [
        'about' => 'pages.access.about'
    ];

    /**
     * Default homepage for the site.
     *
     * @param string $name The name displayed on the hero banner.
     */
    public function index($params)
    {
        $this->assertType($params, 'GET');

        $name = null;
        $user = $this->getUser();

        if (isset($user)) {
            $name = $user->username;
        }

        $this->view('home/index.html', ['name' => $name]);
    }

    /**
     * Static page - About.
     */
    public function about($params)
    {
        $this->assertType($params, 'GET');

        $this->view('home/about.html');
    }

    /**
     * Register page
     */
    public function register($params)
    {
        $this->assertType($params, 'GET');

        $this->view('home/register.html');
    }

    /**
     * Login Page
     */
    public function login($params)
    {
        $this->assertType($params, 'GET');

        $this->view('home/login.html');
    }
}