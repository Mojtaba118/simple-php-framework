<?php


namespace Core;


use App\Middlewares\AuthMiddleware;

class Kernel
{
    /*
     * middleware list
     */
    public static $middlewares=[
      'auth'=>AuthMiddleware::class
    ];
}