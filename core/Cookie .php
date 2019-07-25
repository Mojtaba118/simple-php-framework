<?php


namespace Core;


class Cookie implements StorageInterface
{

    public function has($key)
    {
        return array_key_exists($key,$_COOKIE);
    }

    public function set($key, $value)
    {
        setcookie($key,$value,config("cookie.expier"));
    }

    public function get($key)
    {
        return $this->has($key)?$_COOKIE[$key]:null;
    }

    public function delete($key)
    {
        if ($this->has($key)) unset($_COOKIE[$key]);
    }
}