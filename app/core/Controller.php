<?php

class Controller
{
    public function model($model)
    {
        //todo file check
        require_once '../app/models/' . $model . '.php';

        return new $model();
    }

    public function view($view, $data = [])
    {
        require_once '../app/views/' . $view . '.php';
    }
}