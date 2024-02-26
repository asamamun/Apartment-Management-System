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
$myfn = new myfn\myfn;
$db = new MysqliDb();
$vst_rows = $db->get('apartments'); 
$vst_arr = array();
foreach($vst_rows as $vst_value){
    $vst_arr[$vst_value['id']] = $vst_value['apt_no'];
}
$rows = $db->orderBy('entry_time', 'DESC')->get('visitors');
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
                    <h1>All Visitors</h1><hr />
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Visitors Info
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>apt_id</th>
                                        <th>visitor_name</th>
                                        <th>persons</th>
                                        <th>phone</th>
                                        <th>entry_time</th>
                                        <th>exit_time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
foreach($rows as $row){
    if($row['exit_time'] == null){
        // $ifnull="style='background-color:red'"; 
        $ifnull="style='background-color:#ff6060'";
        $extButton = "<td><a class='btn btn-sm btn-success' href='visitor_func.php?id={$row['id']}&func=exit_func'>Exit</a></td>";
    }else{
        // $ifnull="style='background-color:green'";
        $ifnull="style='background-color:#52bf91'";
        $extButton = "<td></td>";
    }
    echo <<<html
<tr {$ifnull}>
    <td>{$row['id']}</td>
    <td>{$vst_arr[$row['apt_id']]}</td>
    <td>{$row['visitor_name']}</td>
    <td>{$row['persons']}</td>
    <td>{$row['phone']}</td>
    <td>{$row['entry_time']}</td>
    <td>{$row['exit_time']}</td>
    {$extButton}
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
