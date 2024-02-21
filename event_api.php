<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/vendor/autoload.php';
$myfn = new myfn\myfn();
$db = new MysqliDb ();
$db->where('id', $_GET['id']);
$event = $db->getOne('events');
$eventArray = explode(', ', $event['images']);
for ($i=0; $i < count($eventArray); $i++) {
    echo <<<html
<div class="col-lg-4 col-md-4 portfolio-item">
    <a href="admin/{$eventArray[$i]}">
        <div class="portfolio-img"><img src="admin/{$eventArray[$i]}" class="img-thumbnail" alt=""></div>
    </a>
</div>
html;
}