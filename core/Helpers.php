<?php
if (!function_exists('redirect')){
    function redirect($to="/"){
        header("LOCATION: ".$to);
    }
}