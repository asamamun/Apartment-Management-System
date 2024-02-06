<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
session_unset();
session_destroy();
header("location:".settings()['root']);
exit;
?>