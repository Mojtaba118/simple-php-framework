<?php
use Core\Route;
Route::prefix('/api');

Route::get('/','HomeController@index');
Route::get('/admin','HomeController@index');
Route::get('/tutorials/{slug}/episode/{id}','HomeController@index');






