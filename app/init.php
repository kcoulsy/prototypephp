<?php

require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

require_once 'core/App.php';

require_once 'core/Controller.php';


require_once 'database.php';

