<?php


namespace Core;


class Router
{
    public function boot(){
        $this->mapWebRoutes();
        $this->mapApiRoutes();
    }

    private function mapWebRoutes()
    {
        Route::group(['prefix'=>'/'],function (){
            require_once "../route/web.php";
        });
    }

    private function mapApiRoutes()
    {
        Route::group(['prefix'=>'/api'],function (){
            require_once "../route/api.php";
        });
    }
}