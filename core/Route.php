<?php

namespace Core;


class Route
{
    protected static $routes=[];

    protected static $prefix;

    protected static $params=[];

    public static function get($route,$control){
        if ($_SERVER['REQUEST_METHOD']!=="GET") return;
        self::addRoute($route,$control);
    }

    public static function post($route,$control){
        if ($_SERVER['REQUEST_METHOD']!=="POST") return;
        self::addRoute($route,$control);
    }

    private static function addRoute($route,$control){

        $route=preg_replace('/^\//','',$route);

        $route=preg_replace('/\{[a-z]+\}/','(?<\1>[a-zA-Z0-9-]+)',$route);

        $route=preg_replace('/\//','\/',$route);

        if ($route!="")
            $route=self::$prefix.'\/'.$route;
        else
            $route=self::$prefix;

        $route='/^'.$route.'\/?$/';

        $control=is_array($control)?$control['controller']:$control;
        list($params['controller'],$params['method'])=explode('@',$control);
        self::$routes[$route]=$params;
    }

    public static function match($url){
        foreach (self::$routes as $route=>$params){
            if (preg_match($route,$url,$match)){
                foreach ($match as $key=>$value){
                    if (is_string($key)){
                        $params[$key]=$value;
                    }
                }
                self::$params=$params;
                return true;
            }
        }
        return false;
    }

    public static function prefix($prefix){
        $prefix=preg_replace('/^\//','',$prefix);
        $prefix=preg_replace('/\//','\/',$prefix);
        self::$prefix=$prefix;
    }

    public static function getRoutes(){
        return self::$routes;
    }
}