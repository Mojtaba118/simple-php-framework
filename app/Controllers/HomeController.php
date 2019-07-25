<?php


namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller
{
    public function index(){
        echo "HTTP Params: ";
        var_dump(request()->all());
        echo "</br>";
        echo json_encode(["name"=>"mojtaba"]);
    }
}