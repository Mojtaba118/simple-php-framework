<?php

require_once "../bootstrap/bootstrap.php";

//TODO: view()->with()->withError()
//TODO: Add Support For Database And Eloquent
//TODO: Add Auth and auth()
//TODO: Add Validation and valid()
//TODO: Add Blade Engine Support


\Core\Route::dispatch($_SERVER["QUERY_STRING"]);

