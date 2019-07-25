<?php


namespace Core;


class Request implements RequestInterface
{

    public function isPost()
    {
        return $this->getType()=="POST"?true:false;
    }

    public function getType()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function get($key)
    {
        if ($this->isPost()){
            if (array_key_exists($key,$_POST)) return $_POST[$key];
            return null;
        }
        if (array_key_exists($key,$_GET)) return $_GET[$key];
        return null;
    }

    public function all()
    {
        list($param['query'])=explode('&',$_SERVER['QUERY_STRING'],2);
        if ($this->isPost()){
            unset($_POST[$param['query']]);
            return $_POST;
        }
        unset($_GET[$param['query']]);
        return $_GET;
    }
}