<?php
namespace App;
class db{
    public static $conn;
    public static function connect(){
        try{
            self::$conn = new \mysqli(settings()['hostname'],settings()['user'],settings()['password'],settings()['database']) or die("<h1>Connection ERROR!!</h1>");
        return self::$conn;
        }
        catch(\Exception $e){
            echo "<h1>DB Connection ERROR!!</h1>";
            exit;
        }
        
    }
    
}