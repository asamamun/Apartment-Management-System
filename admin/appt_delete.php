<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_GET['id'])){
    require __DIR__ . '/../vendor/autoload.php';
    $myfn = new myfn\myfn();
    $db = new MysqliDb ();
    $id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
    if($id){
        $db->where('id', $id);
        if($db->delete('apartments')){
            header("location: appt_all.php");
        }else{
            echo "something went wrong!! contact the administrator";
            exit;
         }
         }
    $conn->close();
}
?>