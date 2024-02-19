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
// $mem_rows = $db->get('apartments');
// $mem_arr = array();
// foreach($mem_rows as $mem_value){
//     $mem_arr[$mem_value['id']] = $mem_value['apt_no'];
// }
$start_date = $_POST['start_date'] ?? "";
$end_date = $_POST['end_date'] ?? "";
$sql = "SELECT * FROM visitors WHERE entry_time BETWEEN '$start_date' AND '$end_date'";
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
                    <h1>All Users</h1><hr />
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Date Range Search
                        </div>
                        
    <form method="post" action="visitor_search.php">
        From: <input type="date" name="start_date">
        To:<input type="date" name="end_date">
        <input type="submit" name="search" value="Search">
    </form>

                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                  <th>apt_id </th>
                  <th>visitor_name</th>
                  <th>address</th>
                  <th>persons</th>
                  <th>phone</th>
                  <th>purpose</th>
                  <th>entry_time</th>
                  <th>exit_time</th>
                </tr>
        </thead>
    <tbody>
                                <?php
foreach($rows as $row){
    // echo $user['name']."(".$user['email'].")<br>";
    echo <<<html
<tr>
    <td>{$row['id']}</td>
    
    <td>{$row['apt_id']}</td>
    
    <td>{$row['visitor_name']}</td>
   
    <td>{$row['address']}</td>
    <td>{$row['persons']}</td>
    <td>{$row['phone']}</td>
    <td>{$row['purpose']}</td>
    <td>{$row['entry_time']}</td>
    <td>{$row['exit_time']}</td>
   
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
