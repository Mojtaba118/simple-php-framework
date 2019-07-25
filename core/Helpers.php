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
        $config=require_once dirname(__DIR__)."/config/".$parts[0].".php";
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
           if (count($arr[0])!=count($params)) throw new Exception("this route require ".count($arr[0])." params but ".count($params)." given");
           $item=0;
           foreach ($arr[0] as $option){
                $route=str_replace($option,$params[$item],$route);
                $item++;
           }
       }
       if ($route!="")
           return "/".$route;
       else
           throw new Exception("route with name '".$name."' dose not exist",404);
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

if (!function_exists('env')){
    function env($varname,$default=null){
        $value=getenv($varname);
        if (empty($value) && $default!=null)
            return $default;
        switch ($value){
            case "true":
            case "(true)":return true;

            case "false":
            case "(false)": return false;

            case "null":
            case "(null)": return null;

            case "empty":
            case "(empty)": return "";

            default: return $value;
        }
    }
}