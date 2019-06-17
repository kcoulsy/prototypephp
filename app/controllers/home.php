<?php

class Home extends Controller
{
    public function index($name = 'World')
    {
        $this->view('home/index.html', ['name' => $name]);
    }

    public function about()
    {
        $this->view('home/about.html');
    }
}