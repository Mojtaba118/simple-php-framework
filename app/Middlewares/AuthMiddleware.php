<?php


namespace App\Middlewares;


class AuthMiddleware
{

    /**
     * @return bool
     *
     * if the @return value is true then runs method of controller.
     */
    public function run(){
        echo "OK";
        return true;
    }
}