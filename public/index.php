<?php

require_once "../bootstrap/bootstrap.php";

require_once "../route/api.php";


\Core\Route::dispatch($_SERVER["QUERY_STRING"]);

