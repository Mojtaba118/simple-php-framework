<?php


namespace Core;


class Session implements StorageInterface
{

    public function has($key)
    {
        return array_key_exists($key,$_SESSION);
    }

    public function set($key, $value)
    {
        $_SESSION[$key]=$value;
    }

    public function get($key)
    {
        return $this->has($key)?$_SESSION[$key]:null;
    }

    public function delete($key)
    {
        if ($this->has($key)) unset($_SESSION[$key]);
    }

    public function destroy(){
        session_destroy();
    }
}