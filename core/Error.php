<?php


namespace Core;


class Error
{
    public static function errorHandler($level , $message , $file , $line){
        if (error_reporting()!=0)
            throw new \ErrorException($message,0,$level,$file,$line);
    }

    public static function exceptionHandler($exception){
        $code=$exception->getCode();
        if ($code!=404)
            $code=500;

        http_response_code($code);

        if (config("app.debug")){
            echo "<h2>Fatal Error:</h2><br>";
            echo "<h4>Class: ".get_class($exception)."</h4><br>";
            echo "<h4>Message: ".$exception->getMessage()."</h4><br>";
            echo "<h4>Code: ".$code."</h4><br>";
            echo "<h4>File: ".$exception->getFile()."</h4><br>";
            echo "<h4>Line: ".$exception->getLine()."</h4><br>";
            echo "<h4>Stack: ".$exception->getTraceAsString()."</h4><br>";
        }else{
            $path=dirname(__DIR__)."/storage/logs/errors/".date("Y-m-d").".txt";
            $message="\nFatal Error:\n".
                "Class: ".get_class($exception)."\n".
                "Message: ".$exception->getMessage()."\n".
                "Code: ".$code."\n".
                "File: ".$exception->getFile()."\n".
                "Line: ".$exception->getLine()."\n".
                "Stack: ".$exception->getTraceAsString()."\n\n\n";
            ini_set("error_log",$path);
            error_log($message);
            //return view
        }
    }
}