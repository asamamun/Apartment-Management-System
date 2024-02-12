<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
use App\auth\Admin;
if(!Admin::Check()){
    header('HTTP/1.1 503 Service Unavailable');
    exit;
}
$db = new MysqliDb ();
if(isset($_GET['id']) && isset($_GET['get']) && isset($_GET['set'])){
    $get = trim($_GET['get'], "s");
    $db->where($get.'_id', $_GET['id']);
    $rows = $db->get($_GET['set']);
    echo "<option>Select</option>";
    foreach ($rows as $row) {
        echo "<option value='{$row['id']}'>{$row['bn_name']}</option>";
    }
}