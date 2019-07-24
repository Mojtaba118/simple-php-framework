<?php


namespace Core;


use App\Middlewares\AuthMiddleware;

class Kernel
{
    public static $middlewares=[
      'auth'=>AuthMiddleware::class
    ];
}