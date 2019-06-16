<?php

class Home extends Controller
{
    public function index($name = 'test')
    {
        $this->view('home/index.html', ['name' => $name]);
    }

    public function create($username = '', $email = '')
    {
        User::create([
            'username' => $username,
            'email' => $email
        ]);
    }
}