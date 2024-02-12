<?php
$pagename = "jhdsfhkasj";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
use App\auth\Admin;
if(!Admin::Check()){
    header('HTTP/1.1 503 Service Unavailable');
    exit;
}
$myfn = new myfn\myfn;
$db = new MysqliDb ();
$db->where('id', $_GET['id']);
$row = $db->getOne('bills');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="assets/bill.css" rel="stylesheet" />
</head>
<body>
<table class="body-wrap">
    <tbody>
        <tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td class="content-wrap aligncenter">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                    <td class="content-block">
                                        <h2>Thanks for using our app</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <table class="invoice">
                                            <tbody><tr>
                                                <td><?=$row['bill_name']; ?><br>Invoice #<?=$row['id']; ?><br><?=$myfn->only_date($row['created_at']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table class="invoice-items" cellpadding="0" cellspacing="0">
                                                        <tbody>
<?php
$items = $row['items_id'];
$itemsArray = explode(", ", $items);
foreach ($itemsArray as $itemsNumber) {
    $sql = "SELECT bill_items.*, sub_categories.sub_name
    FROM bill_items
    LEFT JOIN sub_categories
    ON bill_items.sub_id = sub_categories.id
    WHERE bill_items.id=$itemsNumber LIMIT 1";
    //$db->where('id', $itemsNumber);
    $results = $db->query($sql);
    foreach ($results as $result) {
        echo <<<html
<tr>
    <td>{$result["sub_name"]}</td>
    <td class="alignright">{$result["amount"]}</td>
</tr> 
html;
    }
}
?>
                                                        
                                                        <tr class="total">
                                                            <td class="alignright" width="80%">Total</td>
                                                            <td class="alignright"><?=$row['amount']; ?> TK</td>
                                                        </tr>
                                                    </tbody></table>
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <a href="#">View in browser</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        Company Inc. 123 Van Ness, San Francisco 94102
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
                <div class="footer">
                    <table width="100%">
                        <tbody><tr>
                            <td class="aligncenter content-block">Questions? Email <a href="mailto:">support@company.inc</a></td>
                        </tr>
                    </tbody></table>
                </div></div>
        </td>
        <td></td>
    </tr>
</tbody>
</table>
</body>
</html>