<?php


namespace App\Controllers;

class HomeController
{
    public function index(){
        echo json_encode(["name"=>"mojtaba"]);
    }
}