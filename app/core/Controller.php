<?php

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
     * Controller constructor
     */
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->loader = new Twig_Loader_Filesystem('../app/views');
        $this->twig = new Twig_Environment($this->loader);

        if (method_exists($this, 'init')) {
            call_user_func([$this, 'init']);
        }
    }

    /**
     * Renders a view from a template file
     *
     * @var string view - template file path
     * @var array data - array params to pass to the view
     */
    public function view($view, $data = [])
    {
        $data['user_logged_in'] = $this->isAuthed();

        $route_url = null;

        if (isset($_GET['url'])) {
            $data['route_url'] = '/' . $_GET['url'];
        }

        echo $this->twig->render($view, $data);
    }

    /**
     * Renders whether or not the user has a session
     *
     * @return bool
     */
    public function isAuthed()
    {
        return isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true;
    }

    /**
     * Gets the currently logged in user
     *
     * @return User model
     */
    public function getUser()
    {
        if (!$this->isAuthed()) {
            return null;
        }

        return $_SESSION['user'];
    }

    /**
     * If the user is not logged in, it redirects to the homepage
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
     * @var string route
     */
    public function redirect($route)
    {
        header('Location: ' . $route);
        die();
    }
}