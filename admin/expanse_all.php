<?php
$pagename = "jhdsfhkasj";
$pagetitle = "";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
$myfn = new myfn\myfn();
use App\auth\Admin;
if(!Admin::Check()){
    header('HTTP/1.1 503 Service Unavailable');
    exit;
}
$db = new MysqliDb ();
?>
<?php require __DIR__.'/components/header.php'; ?>
    </head>
    <body class="sb-nav-fixed">
    <?php require __DIR__.'/components/navbar.php'; ?>
        <div id="layoutSidenav">
        <?php require __DIR__.'/components/sidebar.php'; ?>
            <div id="layoutSidenav_content">
                <main>
                    <!-- changed content -->
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"><?=$myfn->getPageName(__FILE__);?></h1>
                        <hr />
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><h3><?=$pagetitle;?></h3></li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <a class="btn btn-primary" href="cat_create.php"><i class="fas fa-plus"></i></a>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Sub-Category</th>
                                            <th>Admin</th>
                                            <th>Amount</th>
                                            <th>Payment</th>
                                            <th>Create</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Category</th>
                                            <th>Sub-Category</th>
                                            <th>Admin</th>
                                            <th>Amount</th>
                                            <th>Payment</th>
                                            <th>Create</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
<?php
$sql= "SELECT expences.*, users.name as admin, categories.cat_name as catname, sub_categories.sub_name as subname
FROM expences
LEFT JOIN users
ON expences.smt_id=users.id
LEFT JOIN categories
ON expences.cat_id=categories.id
LEFT JOIN sub_categories
ON expences.sub_id=sub_categories.id
WHERE 1";
$rows = $db->query($sql);
foreach ($rows as $row) {
    echo <<<html
<tr>
    <td>{$row['catname']}</td>
    <td>{$row['subname']}</td>
    <td>{$row['admin']}</td>
    <td>{$row['amount']}</td>
    <td>{$row['payment_at']}</td>
    <td>{$row['created_at']}</td>
</tr>
html;
}
?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?=$myfn->msg('msg'); ?>
                    <!-- changed content  ends-->
                </main>
                <!-- footer -->
                <?php require __DIR__.'/components/footer.php'; ?>
            </div>
        </div>
        <?php require __DIR__.'/components/script.php'; ?>
    </body>
</html>
