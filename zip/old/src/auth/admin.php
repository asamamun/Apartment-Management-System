<?php
namespace App\auth;
class Admin{
    public static function startsession(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public static function Check(){
        self::startsession();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] && $_SESSION['role']=="2"){
            return true;
        }
        else return false;
    }
    
}