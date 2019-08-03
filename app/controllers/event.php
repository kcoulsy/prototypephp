<?php

use \Core\Controller as Controller;
use \Model\Player as Player;


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

    /**
     * Create a new event
     *
     * @param array $params
     *
     * @return void
     */
    public function getPlayers($params)
    {
        $this->assertType($params, 'GET');
        $data = Player::get()->toArray();

        if (isset($params['rank'])) {
            $data = array_filter($data, function($val) use ($params) {
                if ($val['rank_index'] <= $params['rank']) {
                    return true;
                }
                return false;
            });
        }
        echo json_encode($data);
    }


}