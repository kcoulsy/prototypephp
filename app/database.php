<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'mvc',
    'charset' => 'utf8',
    'coolation' => 'urf8_unicode_ci',
    'prefix' => ''
]);

$capsule->bootEloquent();
