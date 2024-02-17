<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_GET['id'])){
    require __DIR__ . '/../vendor/autoload.php';
    $db = new MysqliDb ();
    $id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
    if($id){
        $db->where('id', $id);
        if($db->delete('users')){
            header("location: users_all.php");
        }else{
            echo "something went wrong!! contact the administrator";
            exit;
        }
    }
    $$db->close();
}
?>