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
$meet_rows = $db->get('apartment_members');
$meet_row = array();
foreach($meet_rows as $meet_value){
    $meet_arr[$meet_value['id']] = $meet_value['member_name'];
}
$rows = $db->get('meetings');
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
                    <h1>Meeting Members</h1><hr />
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
                                   <th>Title</th>
                                   <th>Date & Time</th>
                                   <!-- <th>Members</th> -->
                                   <th>Details</th>
                                   <th>Created At</th>
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
      <td>{$row['ttitle']}</td>
      <td>{$row['meet_date']}</td>
      <td>{$row['details']}</td>
      <td>{$row['created_at']}</td>
      <td>
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">option</span>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="meet_edit.php?id={$row['id']}">Edit</a></li>
                    <li><a class="dropdown-item" href="meet_delete.php?id={$row['id']}">Delete</a></li>
                    <li><a class="dropdown-item" href="meet_mem.php?id={$meet_arr[$row['members']]}">Members</a></li>
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
<!-- <td>{$meet_arr[$row['members']]}</td> -->