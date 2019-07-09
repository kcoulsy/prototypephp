<?php

/**
 * Default route controller
 */
class Home extends Controller
{
    /**
     * Required roles for specific routes
     *
     * @var array
     */
    public $protected_roles = [
        'about' => 'pages.access.about'
    ];

    /**
     * Default homepage for the site.
     *
     * @param string $name The name displayed on the hero banner.
     *
     * @return void
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
     * Static about page
     *
     * @param array $params
     *
     * @return void
     */
    public function about($params)
    {
        $this->assertType($params, 'GET');

        $this->view('home/about.html');
    }

    /**
     * Register form page
     *
     * @param array $params
     *
     * @return void
     */
    public function register($params)
    {
        $this->assertType($params, 'GET');

        $this->view('home/register.html');
    }

    /**
     * Login form page
     *
     * @param array $params
     *
     * @return void
     */
    public function login($params)
    {
        $this->assertType($params, 'GET');

        $this->view('home/login.html');
    }
}