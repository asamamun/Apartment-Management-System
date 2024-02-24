<?php
if (!function_exists('settings')) {
    function settings()
    {
       $root = "http://localhost/Apartment-Management-System/"; 
        return [
            'root'  => $root,
            'companyname'=> 'Housing Society',
            'title'=> 'Housing Society',
            'logo'=>$root."admin/stroage/VV-Society-Logo-removebg-preview.png",
            'homepage'=> $root,
            'adminpage'=>$root.'admin/',
            'hostname'=> 'localhost',
            'user'=> 'root',
            'password'=> '',
            'database'=> 'lioncommerce'
        ];
    }
}
if (!function_exists('testfunc')) {
    function testfunc()
    {
        return "<h3>testing common functions</h3>";
    }
}
if (!function_exists('config')) {
    function config($param)
    {        
      $parts = explode(".",$param);
      $inc = include(__DIR__."/../config/".$parts[0].".php");
      return $inc[$parts[1]];
    }
}
