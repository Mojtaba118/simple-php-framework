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
        if ($this->isPost())
            return $_POST;
        return $_GET;
    }
}