<?php

use app\core\Router;
require 'autoload.php';

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);


$route = new Router();
$route->run();

