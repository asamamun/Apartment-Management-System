<?php
date_default_timezone_set('Asia/Dhaka');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
$db = new MysqliDb ();
if(isset($_GET["func"]) && $_GET["func"] == "exit_func"){
    $id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
    $data = [
        'exit_id'=> $_SESSION["userid"],
        'exit_time' => date("Y-m-d h:i:s"),
    ];
    $db->where('id', $id);
    $db->update('visitors', $data);
    header("location: ".$_SERVER["HTTP_REFERER"]);
}