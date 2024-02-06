<?php require __DIR__ . '/../vendor/autoload.php'; ?>
<?php
$db = new MysqliDb();
//https://github.com/ThingEngineer/PHP-MySQLi-Database-Class#insert-query
$data = [
    'category_id'=>'5',
    'subcategory_id'=>'6',
    'name'=>'testing db class',
    'description'=>'testing db class insert',
    'sku'=>'dbclass01'.rand(),
    'images'=>'imagenameee.png',
    'price'=>'1000',
    'quantity'=>'100',
    'discount'=>'5',
    'hot'=>'1',
];
$id = $db->insert ('products', $data);
echo "record added. ID: " . $id;
echo "<hr>";
echo $db->getLastQuery();