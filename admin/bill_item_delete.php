<?php
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

$sql = "SELECT bill_items.*, categories.cat_name, sub_categories.sub_name
FROM bill_items
LEFT JOIN categories
ON bill_items.cat_id = categories.id
LEFT JOIN sub_categories
ON bill_items.sub_id = sub_categories.id
WHERE bill_items.status = 0";
$rows = $db->query($sql);
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
                        <h1 class="mt-4">All Bill Items</h1>
                        <hr />
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">যে সকল বিল ব্যাবহার উপযোগি সেই গুলোই এখানে পাওয়া যাবে।</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>cat name</th>
                                            <th>sub name</th>
                                            <th>amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>cat name</th>
                                            <th>sub name</th>
                                            <th>amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
<?php
foreach ($rows as $row) {
    $isblock = null;
    if($row['status'] == 0){
        $isblock = "<a class='btn btn-danger' href='bill_func.php?block_id={$row['id']}&status=1'>Unblock</a>";
    }else{
        $isblock = "<a class='btn btn-danger' href='bill_func.php?block_id={$row['id']}&status=0'>Block</a>";
    }
    echo <<<html
<tr>
    <td>{$row['id']}</td>
    <td>{$row['cat_name']}</td>
    <td>{$row['sub_name']}</td>
    <td>{$row['amount']}</td>
    <td>{$isblock}</td>
</tr>
html;
}
?>
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- changed content  ends-->
                </main>
<!-- footer -->
<?php require __DIR__.'/components/footer.php'; ?>
            </div>
        </div>
        <script src="<?= settings()['adminpage'] ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?= settings()['adminpage'] ?>assets/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="<?= settings()['adminpage'] ?>assets/demo/chart-area-demo.js"></script>
        <script src="<?= settings()['adminpage'] ?>assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="<?= settings()['adminpage'] ?>assets/js/datatables-simple-demo.js"></script>
    </body>
</html>
