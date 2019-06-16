<?php

class Controller
{
    protected $loader;
    protected $twig;
    protected $lexer;

    public function __construct()
    {
        $this->loader = new Twig_Loader_Filesystem('../app/views');
        $this->twig = new Twig_Environment($this->loader);
    }

    public function model($model)
    {
        //todo file check
        require_once '../app/models/' . $model . '.php';

        return new $model();
    }

    public function view($view, $data = [])
    {
        echo $this->twig->render($view, $data);
    }
}