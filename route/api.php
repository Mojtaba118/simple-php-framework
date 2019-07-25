<?php
use Core\Route;

//TODO: Test Route Scenarios For Route::group and $prefix


Route::group(['prefix'=>'/v1','namespace'=>'Admin','middleware'=>'auth'],function (){
    Route::get("/admin","AdminController@index");
});



