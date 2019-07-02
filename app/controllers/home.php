<?php

class Home extends Controller
{
    /**
     * Default homepage for the site.
     *
     * @param string $name The name displayed on the hero banner.
     */
    public function index($params)
    {
        $name = 'World';

        if (isset($_SESSION["loggedin"])) {
            $name = $_SESSION["user"]->password;
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