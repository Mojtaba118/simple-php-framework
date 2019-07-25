<?php
use Core\Route;

//TODO: Test Route Scenarios For Route::group and $prefix
//TODO:Add Middleware to a route inside of route group

Route::group(['prefix'=>'/v1','namespace'=>'Admin','middleware'=>'auth'],function (){
    Route::get("/admin","AdminController@index");
});



