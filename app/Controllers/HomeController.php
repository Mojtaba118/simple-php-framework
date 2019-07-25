<?php


namespace App\Controllers;

use Core\Controller;
use Core\View;

class HomeController extends Controller
{
    public function index(){
        View::render("index",["name"=>"mojtaba"]);
        //view('admin.index',compact())->with(["variable"=>"value"])
        //                             ->withError([messages])
    }
}