<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/vendor/autoload.php';
use App\User;
use App\model\Category;
// use App\db;
// $conn = db::connect();
$db = new MysqliDb ();
$page = "Home";
?>
<?php require __DIR__ . '/components/header.php';?>

</head>
<body>
    <div class="container">
<img src="<?= settings()['logo'] ?>" alt="">
<?php require __DIR__ . '/components/menubar.php';?>
<?php
echo testfunc();
// var_dump(settings());
$u = new User();
echo $u->testme();
?>
<?php
// $r = $conn->query("select * from users");
$users = $db->get('users');
// var_dump($users);
foreach($users as $user){
    echo $user['name']."(".$user['email'].")<br>";
}
echo "<h1>Total Users: ".count($users)."</h1>";
?>
<hr>
<?php
echo Category::testing();
?>
<hr>
<?php
echo config('idb.name');
?>
<hr>
<?php
echo config('test.round');
?>
<hr>
<h3>Autoloading Settings() function in src/settings.php file in composer.json :</h3>
<pre>
<?php
var_dump(settings());
?>
</pre>

</div>
<script>
    
</script>

<?php 
require __DIR__ . '/components/footer.php'; 
$db->disconnect();
?>
