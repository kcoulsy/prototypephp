<?php

class Home extends Controller
{
    /**
     * Default homepage for the site.
     *
     * @param string $name The name displayed on the hero banner.
     */
    public function index($name = 'World')
    {
        $this->view('home/index.html', ['name' => $name]);
    }

    /**
     * Static page - About.
     */
    public function about()
    {
        $this->view('home/about.html');
    }
}