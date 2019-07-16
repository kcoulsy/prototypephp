<?php

namespace Core;

use \Helpers\AuthController as AuthController;

/**
 * Core controller classes
 */
class Controller
{
    /**
     * Twig filesystem loader.
     *
     * @var Object
     */
    protected $loader;

    /**
     * Twig environment controller.
     *
     * @var Object
     */
    protected $twig;

    /**
     * Twig lexer.
     *
     * @var Object
     */
    protected $lexer;

    /**
     * Controller constructor
     */
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->loader = new \Twig_Loader_Filesystem('../app/views');
        $this->twig = new \Twig_Environment($this->loader);

        $this->lexer = new \Twig_Lexer($this->twig, [
            'tag_comment'   => ['{#', '#}'],
            'tag_block'     => ['{%', '%}'],
            'tag_variable'  => ['{*', '*}'],
            'interpolation' => ['#{', '}'],
        ]);

        $this->twig->setLexer($this->lexer);

        if (method_exists($this, 'init')) {
            call_user_func([$this, 'init']);
        }
    }

    /**
     * Renders a view from a template file
     *
     * @param string $view - template file path
     * @param array $data - array params to pass to the view
     *
     * @return void
     */
    public function view($view, $data = [])
    {
        $data['user_logged_in'] = $this->isAuthed();

        if (isset($_GET['url'])) {
            $data['route_url'] = '/' . $_GET['url'];
        }

        // roles specific to navbars
        $data['nav_roles'] = AuthController::hasRoles([
            'admin.access',
            'admin.access.users',
            'admin.access.groups',
            'pages.access.about',
            'pages.access.news'
        ]);

        echo $this->twig->render($view, $data);
    }

    /**
     * Renders whether or not the user has a session
     *
     * @return bool
     */
    public function isAuthed()
    {
        return AuthController::isLoggedIn();
    }

    /**
     * Gets the currently logged in user
     *
     * @return User model
     */
    public function getUser()
    {
        return AuthController::getUser();
    }

    /**
     * If the user is not logged in, it redirects to the homepage
     *
     * @return void
     */
    public function requireAuth()
    {
        if (!$this->isAuthed()) {
            $this->redirect('/');
        }
    }

    /**
     * Route to redirect to
     *
     * @param string route
     *
     * @return void
     */
    public function redirect($route)
    {
        header('Location: ' . $route);
        die();
    }

    /**
     * Loops from required params, throwing error they don't exist
     *
     * @param array $params
     * @param array $required
     *
     * @return void
     *
     * @throws \Exception
     */
    public function requireParams($params = [], $required = [])
    {
        try {
            $missing_params = [];
            if (count($required) > 0) {
                foreach($required as $key) {
                    if (!isset($params[$key])) {
                        array_push($missing_params, $key);
                    }
                }
                if (count($missing_params) > 0) {
                    throw new \Exception('Missing Parameters: ' . implode('', $missing_params));
                }
            }
        } catch (\Exception $e) {
            echo 'Error Occurred: ' . $e->getMessage();
            die();
        }
    }

    /**
     * Asserts the request is either a POST or GET
     *
     * @param array $params
     * @param string $type
     *
     * @return void
     *
     * @throws \Exception
     */
    public function assertType($params = [], $type)
    {
        try {
            if (!isset($params['request_type'])) {
                throw new \Exception('Request Type not found');
            }
            if (!isset($type)) {
                throw new \Exception('Missing 2nd param $type');
            }

            $recieved = strtoupper($params['request_type']);
            $expected = strtoupper($type);

            $valid_types = ['GET', 'POST'];

            if (!in_array($expected, $valid_types)) {
                throw new \Exception(
                    'Request type not valid. Recieved: ' .
                    $recieved .
                    '. Must of be one of the following types: ' .
                    implode(', ', $valid_types)
                );
            }


            if ($expected != $recieved) {
                throw new \Exception(
                    'Request type does not match the required type. Expected: ' .
                    $expected .
                    ' Recieved: ' .
                    $recieved
                );
            }
        } catch (\Exception $e) {
            echo 'Error Occurred: ' . $e->getMessage();
            die();
        }
    }
}
