<?php
use Core\Route;

Route::group(['prefix'=>'/admin'],function (){
   Route::get('/','HomeController@index');
});
