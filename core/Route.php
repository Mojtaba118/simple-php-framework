<?php

namespace Core;


class Route
{
    protected static $routes=[];
    protected static $prefix;
    public static function get($route,$control){
        if ($_SERVER['REQUEST_METHOD']!=="GET") return;
        $control=is_array($control)?$control['controller']:$control;

        list($params['controller'],$params['method'])=explode('@',$control);

        self::$routes[self::$prefix.$route]=$params;
    }

    public static function post($route,$params){
        if ($_SERVER['REQUEST_METHOD']!=="POST") return;
        echo "OK POST";
    }

    public static function prefix($prefix){
        self::$prefix=$prefix;
    }

    public static function getRoutes(){
        return self::$routes;
    }
}