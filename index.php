<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/vendor/autoload.php';
use App\User;
use App\model\Category;
$db = new MysqliDb();
$page = "Home";
?>
<?php require __DIR__ . '/components/header.php'; ?>
</head>
<body>
    <div class="container">
        <?php require __DIR__ . '/components/menubar.php';?>
    </div>
<script>
</script>
<?php 
require __DIR__ . '/components/footer.php'; 
$db->disconnect();
?>
