<?php
use Core\Route;
Route::prefix('/api');

Route::get('/','HomeController@index')
    ->name("home.index")
    ->middleware("auth");
//Route::get('/admin','Admin\\AdminController@index');
//Route::get('/tutorials/{slug}/episode/{id}','TutorialsController@episode');






