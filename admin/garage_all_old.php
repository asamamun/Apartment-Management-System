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
$gar_rows = $db->get('users');
$gar_row = array();
foreach($gar_rows as $gar_value){
    $gar_arr[$gar_value['id']] = $gar_value['name'];
}
$rows = $db->get('garages');
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
                                   <th>ID</th>
                                   <th>User</th>
                                   <th>Garage No</th>
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
      <td>{$gar_arr[$row['user_id']]}</td>
      <td>{$row['gar_no']}</td>
      <td>
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">option</span>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="garage_edit.php?id={$row['id']}">Edit</a></li>
                    <li><a class="dropdown-item" href="garage_delete.php?id={$row['id']}">Delete</a></li>
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
