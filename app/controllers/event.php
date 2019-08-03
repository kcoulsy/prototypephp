<?php

use \Core\Controller as Controller;

/**
 * Default route controller
 */
class Event extends Controller
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
     * Create a new event
     *
     * @param array $params
     *
     * @return void
     */
    public function create($params)
    {
        $this->assertType($params, 'GET');

        $this->view('events/create.html');
    }


}