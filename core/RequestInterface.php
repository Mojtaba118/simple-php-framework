<?php


namespace Core;


interface RequestInterface
{
    public function isPost();
    public function getType();
    public function get($key);
    public function all();
}