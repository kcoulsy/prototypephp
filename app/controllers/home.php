<?php

class Home extends Controller
{
    public function index($name = 'test')
    {
        echo $name;
    }

}