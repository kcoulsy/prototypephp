<?php

class Admin extends Controller
{
    /**
     * Default homepage for the admin page
     */
    public function index()
    {

        $this->view('home/index.html');
    }
}
