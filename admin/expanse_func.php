<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
$myfn = new myfn\myfn();
use App\auth\Admin;
if(!Admin::Check()){
    header('HTTP/1.1 503 Service Unavailable');
    exit;
}
$db = new MysqliDb ();
if(isset($_GET['block_id'])){
    $id = filter_var($_GET['block_id'],FILTER_VALIDATE_INT);
    if($id){
        $db->where('id', $id);
        if($db->update('users',['role' => $_GET['role']])){
            $myfn->msg('msg',"Operation Done");
            header("location: ".$_SERVER["HTTP_REFERER"]);
            exit;
        }else{
            $myfn->msg('msg',"server problem please chack!!");
            header("location: ".$_SERVER["HTTP_REFERER"]);
            exit;
        }
    }
    $db->close();
}
?>