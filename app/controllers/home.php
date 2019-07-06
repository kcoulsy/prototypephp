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
    public function about()
    {
        $this->view('home/about.html');
    }

    /**
     * Register page
     */
    public function register()
    {
        $this->view('home/register.html');
    }

    /**
     * Login Page
     */
    public function login()
    {
        $this->view('home/login.html');
    }
}