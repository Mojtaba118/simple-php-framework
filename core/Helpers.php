<?php
if (!function_exists('redirect')){
    function redirect($to="/"){
        header("Location: ".$to);
        die;
    }
}

if (!function_exists('config')){
    function config($path){
        if ($path=="")return false;
        $parts=explode('.',$path);
        $config=require_once __DIR__."/../config/".$parts[0].".php";
        for ($i=1;$i<count($parts);$i++){
            if (is_array($config)){
                if (array_key_exists($parts[$i],$config))
                    $config=$config[$parts[$i]];
                else
                    return false;
            }
        }
        return $config;
    }
}

if (!function_exists('route')){
    function route($name="",$params=[]){
       $routes= \Core\Route::getRoutes();
       $route="";
       foreach ($routes as $routeOption){
           if ($name==$routeOption->name){
               $route=$routeOption->route;
               break;
           }
       }
       if (preg_match_all("/\{[a-z]+\}/",$route,$arr)){
           if (count($arr[0])!=count($params)) return "this route require ".count($arr[0])." params but ".count($params)." given.";
           $item=0;
           foreach ($arr[0] as $option){
                $route=str_replace($option,$params[$item],$route);
                $item++;
           }
       }
       return "/".$route;
    }
}

if (!function_exists('request')){
    function request($key=null){
        $request=new \Core\Request();
        if ($key!=null) return $request->get($key);
        return $request;
    }
}

if (!function_exists('cookie')){
    function cookie($key=null,$value=null){
        $cookie=new \Core\Cookie();
        if ($key!=null && $value!=null)
            $cookie->set($key,$value);
        else if($key!=null)
            return $cookie->get($key);
        else
            return $cookie;
    }
}

if (!function_exists('session')){
    function session($key=null,$value=null){
        $session=new \Core\Session();
        if ($key!=null && $value!=null)
            $session->set($key,$value);
        else if($key!=null)
            return $session->get($key);
        else
            return $session;
    }
}