<?php

require_once "../bootstrap/bootstrap.php";

require_once "../route/api.php";


var_dump(\Core\Route::match($_SERVER["QUERY_STRING"]));

