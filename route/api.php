<?php
use Core\Route;


Route::group(['prefix'=>'/v1','namespace'=>'Admin','middleware'=>'auth'],function (){
    Route::get("/admin","AdminController@index");
});



