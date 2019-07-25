<?php


namespace Core;


class View
{
    const PATH="/resources/views/";
    public static function render($view,$args=[]){
        extract($args,EXTR_SKIP);

        $file=dirname(__DIR__).self::PATH.$view.".php";
        if (is_readable($file))
            require_once $file;
        else
            throw new \Exception("View Not Found: $view");
    }
}