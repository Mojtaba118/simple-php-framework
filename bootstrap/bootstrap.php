<?php

require_once "../vendor/autoload.php";

error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


$router=new \Core\Router();
$router->boot();
