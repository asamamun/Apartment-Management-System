<?php require __DIR__ . '/../vendor/autoload.php'; ?>
<?php
use App\User;
$db = new MysqliDb();
//https://github.com/ThingEngineer/PHP-MySQLi-Database-Class#select-query
// $db->where("category_id","1");
// $products = $db->get("products",5);
// $db->pageLimit=9;
$products = $db->paginate("products",1);
echo count($products) . " products<hr>";
foreach($products as $p){
    echo "<h3>Name : ".$p['name']."</h3>";
    echo "<p>CID: ".$p['category_id']."</p><hr>";
}
$db->disconnect();
?>
<hr>
<?php
$u = new User();
echo $u->testme();