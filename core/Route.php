<?php

namespace Core;


use mysql_xdevapi\Exception;

class Route
{
    protected static $routes=[];

    protected static $route=null;

    protected static $params;

    protected static $prefix="";

    protected static  $namespace="App\\Controllers\\";

    protected static $middleware="";

    public static function get($route,$control){
        self::$route=null;
        if (request()->getType()=="GET")
            self::addRoute($route,$control);
        return new static();
    }

    public static function post($route,$control){
        self::$route=null;
        if (request()->getType()=="POST")
            self::addRoute($route,$control);
        return new static();
    }

    public static function put($route,$control){
        self::$route=null;
        if (request()->getType()=="PUT")
            self::addRoute($route,$control);
        return new static();
    }

    public static function patch($route,$control){
        self::$route=null;
        if (request()->getType()=="PATCH")
            self::addRoute($route,$control);
        return new static();
    }

    public static function delete($route,$control){
        self::$route=null;
        if (request()->getType()=="DELETE")
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
        $routeOptions->controller=self::$namespace.$params['controller'];
        $routeOptions->method=$params['method'];
        $routeOptions->route=self::$route;
        $routeOptions->routeRegex=$route;
        $routeOptions->middleware=self::$middleware;

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
        if (!self::match($url)) throw new \Exception("Not Found",404);
        $className=self::$params->controller;
        $method=self::$params->method;
        if (!self::handleMiddleware(self::$params)) return;
        if (class_exists($className)){
            $controller=new $className();
            if (method_exists($controller,$method)){
                if (is_callable([$controller,$method])){
                    call_user_func_array([$controller,$method],self::$params->params);
                }else{
                    throw new \Exception("Method Is Not Accessible");
                }
            }else{
                throw new \Exception("Method Not Found: '$method' in '$className'");
            }
        }else{
            throw new \Exception("Controller Not Found: '$className'");
        }
    }

    protected static function prefix($prefix){
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
                    if ($options->middleware=="")
                        $options->middleware=$middleware;
                    else
                        $options->middleware.="|".$middleware;
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
            if (array_key_exists($mid,$middlewares)){
                var_dump($mid);
                $middleware=$middlewares[$mid];
                if (class_exists($middleware)){
                    $middlewareObject=new $middleware();
                    if (method_exists($middlewareObject,"run")){
                        if (is_callable([$middlewareObject,"run"])){
                            if (call_user_func([$middlewareObject,"run"])){
                                continue;
                            }
                            $error=true;
                            break;

                        }else{
                            throw new \Exception("Method Is Not Accessible");
                        }
                    }else{
                        throw new \Exception("Method Not Found: 'run'");
                    }
                }else{
                    throw new \Exception("Middleware Not Found: '$mid'");
                }
            }else{
                $error=true;
                break;
            }
        }
        return !$error;
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

    public static function group($option=[],$cb){
        $oldPrefix=self::$prefix;
        if (array_key_exists("prefix",$option)){
            if (self::$prefix=="")
                self::prefix($option['prefix']);
            else
                self::$prefix.=$option['prefix'];
        }
        if (array_key_exists("namespace",$option)){
            self::$namespace=self::$namespace.$option["namespace"]."\\";
        }
        if (array_key_exists("middleware",$option)){
            self::$middleware=$option["middleware"];
        }
        $cb();
        self::$prefix=$oldPrefix;
        self::$namespace="App\\Controllers\\";
        self::$middleware="";

    }
}