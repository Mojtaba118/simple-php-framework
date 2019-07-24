<?php

namespace Core;


class Route
{
    protected static $routes=[];

    protected static $prefix;

    protected static $route=null;

    protected static $params;

    protected static  $namespace="App\\Controllers\\";

    public static function get($route,$control){
        self::$route=null;
        if ($_SERVER['REQUEST_METHOD']=="GET")
            self::addRoute($route,$control);
        return new static();
    }

    public static function post($route,$control){
        self::$route=null;
        if ($_SERVER['REQUEST_METHOD']!=="POST")
            self::addRoute($route,$control);
        return new static();
    }

    public static function put($route,$control){
        self::$route=null;
        if ($_SERVER['REQUEST_METHOD']!=="PUT")
            self::addRoute($route,$control);
        return new static();
    }

    public static function patch($route,$control){
        self::$route=null;
        if ($_SERVER['REQUEST_METHOD']!=="PATCH")
            self::addRoute($route,$control);
        return new static();
    }

    public static function delete($route,$control){
        self::$route=null;
        if ($_SERVER['REQUEST_METHOD']!=="DELETE")
            self::addRoute($route,$control);
        return new static();
    }

    protected static function addRoute($route,$control){

        $route=preg_replace('/^\//','',$route);
        if ($route!="" && self::$prefix!="")
            $route=self::$prefix.'/'.$route;
        else if ($route=="" && self::$prefix!="")
            $route=self::$prefix;

        self::$route=$route;

        $route=preg_replace('/\{([a-z]+)\}/','(?<\1>[a-zA-Z0-9-]+)',$route);

        $route=preg_replace('/\//','\/',$route);

        $route='/^'.$route.'\/?$/';

        $control=is_array($control)?$control['controller']:$control;
        list($params['controller'],$params['method'])=explode('@',$control);

        $routeOptions=new RouteOptions();
        $routeOptions->controller=$params['controller'];
        $routeOptions->method=$params['method'];
        $routeOptions->route=self::$route;
        $routeOptions->routeRegex=$route;

        self::$routes[$route]=$routeOptions;
    }

    protected static function match($url){
        foreach (self::$routes as $route=>$options){
            if (preg_match($route,$url,$match)){
                foreach ($match as $key=>$value){
                    if (is_string($key)){
                        $options->params[$key]=$value;
                    }
                }
                self::$params=$options;
                return true;
            }
        }
        return false;
    }

    public static function dispatch($url){

        $url=self::removeHttpParams($url);
        if (!self::match($url)) return;
        $className=self::$namespace.self::$params->controller;
        $method=self::$params->method;
        if (!self::handleMiddleware(self::$params)) return;
        if (class_exists($className)){
            $controller=new $className();
            if (method_exists($controller,$method)){
                if (is_callable([$controller,$method])){
                    call_user_func_array([$controller,$method],self::$params->params);
                }else{
                    echo "Method Not Accessible";
                }
            }else{
                echo "Method Not Found";
            }
        }else{
            echo "Controller Not Found";
        }
    }

    public static function prefix($prefix){
        $prefix=preg_replace('/^\//','',$prefix);
        self::$prefix=$prefix;
    }

    public static function name($name){
        if (self::$route!=null) {
            foreach (self::$routes as $route => $options) {
                if ($options->route === self::$route) {
                    $options->name = $name;
                    break;
                }
            }
        }
        return new static();
    }

    public static function middleware($middleware){
        if (self::$route!=null){
            foreach (self::$routes as $route=>$options){
                if ($options->route===self::$route){
                    $options->middleware=$middleware;
                    break;
                }
            }
        }
        return new static();
    }

    public static function getRoutes(){
        return self::$routes;
    }

    protected static function getParams(){
        return self::$params;
    }

    protected static function handleMiddleware($params)
    {
        if ($params->middleware=="") return true;
        $error=false;
        $middlewares=Kernel::$middlewares;
        $currentMiddleware=explode('|',$params->middleware);
        foreach ($currentMiddleware as $mid) {
            foreach ($middlewares as $key => $middleware) {
                if ($key == $mid) {
                    if (class_exists($middleware)){
                        $controller=new $middleware();
                        if (method_exists($controller,"run")){
                            if (is_callable([$controller,"run"])){
                                if (call_user_func([$controller,"run"])){
                                    continue;
                                }
                                $error=true;
                                break;
                            }else{
                                echo "Method Not Accessible";
                            }
                        }else{
                            echo "Method Not Found";
                        }
                    }else{
                        echo "Middleware Not Found";
                    }
                }
            }
        }
        if ($error)
            return false;
        else
            return true;
    }

    protected static function removeHttpParams($url)
    {
        if ($url!=""){
            $parts=explode('&',$url,2);
            if (strpos($parts[0],'=')==false)
                $url=$parts[0];
        }
        return $url;
    }
}