<?php

require_once "../bootstrap/bootstrap.php";

//var_dump(\Core\Route::getRoutes());

\Core\Route::dispatch($_SERVER["QUERY_STRING"]);

