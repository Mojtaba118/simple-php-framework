<?php


namespace App\Middlewares;


class AuthMiddleware
{
    public function run(){
        echo "OK";
        return true;
    }
}