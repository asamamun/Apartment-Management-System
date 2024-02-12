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
$db = new MysqliDb ();
$mem_rows = $db->get('apartments');
$mem_arr = array();
foreach($mem_rows as $mem_value){
    $mem_arr[$mem_value['id']] = $mem_value['apt_no'];
}
$keywords = $_GET['keywords'] ?? "";
$sql = "SELECT 	* FROM apartment_members WHERE `member_name` LIKE '%$keywords%'";
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
                    <h1>All Users</h1><hr />
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Example
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>apt_no</th>
                                        <th>member_name</th>
                                        <th>dob</th>
                                        <th>nid</th>
                                        <th>image</th>
                                        <th>status</th>
                                        <th>created_at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
foreach($rows as $row){
    // echo $user['name']."(".$user['email'].")<br>";
    echo <<<html
<tr>
    <td>{$row['id']}</td>
    <td>{$mem_arr[$row['apt_id']]}</td>
    <td>{$row['member_name']}</td>
    <td>{$myfn->only_date($row['dob'])}</td>
    <td>{$row['nid']}</td>
    <td><img src="{$row['images']}" width="40" height="40"/></td>
    <td>{$row['status']}</td>
    <td>{$row['created_at']}</td>
    <td>
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">option</span>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="mem_edit.php?id={$row['id']}">Edit</a></li>
                    <li><a class="dropdown-item" href="mem_delete.php?id={$row['id']}">Delete</a></li>
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
