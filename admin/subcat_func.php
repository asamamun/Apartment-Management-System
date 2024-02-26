<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
$db = new MysqliDb ();
use App\auth\Admin;
if(!Admin::Check()){
    header('HTTP/1.1 503 Service Unavailable');
    exit;
}
if(isset($_GET['block'])){
    $id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
    if($id){
        $db->where('id', $id);
        if($db->update('sub_categories', ['status' => $_GET['status']])){
            header("location: subcat_all.php");
            exit;
        }else{
            header("location: ".$_SERVER["HTTP_REFERER"]);
            exit;
        }
    }
    //$conn->close();
}
?>