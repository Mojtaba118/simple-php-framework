<?php
use Core\Route;
Route::prefix('/api');
Route::get('/admin','HomeController@index');

