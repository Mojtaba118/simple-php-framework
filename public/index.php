<?php

require_once "../bootstrap/bootstrap.php";

//var_dump(\Core\Route::getRoutes());
//var_dump(request()->all());
//var_dump(__DIR__);
//var_dump(dirname(__DIR__));
//var_dump(ini_get('hello'));
//var_dump(env("APP_NAME","php"));

\Core\Route::dispatch($_SERVER["QUERY_STRING"]);

