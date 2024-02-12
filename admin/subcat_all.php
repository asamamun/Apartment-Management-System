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
$cat_rows = $db->get('categories');
$cat_arr = array();
foreach($cat_rows as $cat_value){
    $cat_arr[$cat_value['id']] = $cat_value['cat_name'];
}
if(isset($_GET["type"])){
    $db->where("type", $_GET["type"]);
}
$rows = $db->get('sub_categories');
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
                        <h1 class="mt-4">Dashboard</h1>
                        <hr />
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
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
                                            <th>Cat Name</th>
                                            <th>Sub Name</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cat Name</th>
                                            <th>Sub Name</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
<?php
foreach($rows as $row){
    $type = $row['type'] == 1 ? 'Income' : 'expanse';
    echo <<<html
<tr>
    <td>{$row['id']}</td>
    <td>{$cat_arr[$row['cat_id']]}</td>
    <td>{$row['sub_name']}</td>
    <td>{$type}</td>
    <td>
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">option</span>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="subcat_edit.php?id={$row['id']}">Edit</a></li>
                    <li><a class="dropdown-item" href="subcat_delete.php?id={$row['id']}">Delete</a></li>
                </ul>
            </div>
        </div>
    </td>
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
