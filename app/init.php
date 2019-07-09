<?php

require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

require_once 'core/App.php';

require_once 'core/Controller.php';

require_once 'helpers/AuthController.php';
require_once 'helpers/EmailController.php';
require_once 'helpers/UploadController.php';

require_once 'database.php';

