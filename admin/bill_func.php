<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
$myfn = new myfn\myfn();
$db = new MysqliDb ();
use App\auth\Admin;
if(!Admin::Check()){
    header('HTTP/1.1 503 Service Unavailable');
    exit;
}
if(isset($_GET['expire'])){
    $id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
    if($id){
        $db->where('id', $id);
        if($db->update('bills', ['status' => 0])){
            $myfn->msg('msg', "Operation Done");
            header("location: ".$_SERVER["HTTP_REFERER"]);
            exit;
        }else{
            $myfn->msg('msg', "error something went wrong!! contact the administrator");
            header("location: ".$_SERVER["HTTP_REFERER"]);
            exit;
        }
    }
    $db->disconnect();
}
?>