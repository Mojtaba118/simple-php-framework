<?php


namespace Core;


interface StorageInterface
{
    public function has($key);
    public function set($key,$value);
    public function get($key);
    public function delete($key);
}