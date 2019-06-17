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
        $this->loader = new Twig_Loader_Filesystem('../app/views');
        $this->twig = new Twig_Environment($this->loader);
    }

    /**
     * Renders a view from a template file
     *
     * @var string view - template file path
     * @var array data - array params to pass to the view
     */
    public function view($view, $data = [])
    {
        echo $this->twig->render($view, $data);
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