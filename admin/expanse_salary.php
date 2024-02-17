<?php
date_default_timezone_set("Asia/Dhaka");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
use App\auth\Admin;
if(!Admin::Check()){
    header('HTTP/1.1 503 Service Unavailable');
    exit;
}
$myfn = new myfn\myfn();
$db = new MysqliDb ();
if(isset($_POST['submit'])){
  $data = [
        'emp_id'=> $db->escape($_POST['emp_id']),
        'amount'=> $db->escape($_POST['amount']),
        'details'=> $db->escape($_POST['details'] ?? null)
  ];
  if($db->insert("emp_salary", $data)){
        $myfn->msg('msg', "Operation Done");
        header("location: expanse_salary.php");
        exit;
  }
  else{
        $myfn->msg('msg',"server problem please chack!!");
  }
}
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
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row" id="hideForm">
                            <div class="col-md-2"></div>
                            <div class="col-md-8 border border-info rounded p-4">
                                <form action="" method="post">
                                    <div class="mb-3 mt-3">
                                        <label for="emp_id" class="form-label">Employ Name</label>
                                        <select class="form-control" id="emp_id" name="emp_id">
                                            <option>select</option>
<?php
$emp_rows = $db->get("employees");
foreach ($emp_rows as $emp_row) {
    echo "<option value='{$emp_row['id']}'>{$emp_row['emp_name']}</option>";
}
?>
                                        </select>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="amount" class="form-label">Amount</label>
                                        <input type="text" class="form-control" id="amount"  name="amount"  required>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <!-- <label for="details" class="form-label">Details</label> -->
                                        <textarea class="form-control" id="details"  name="details"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit" value="category">Income Item Set</button>
                                </form>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                    <div class="row m-4">
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <button class="btn btn-info" id="buttonForm"><i class="fas fa-plus"></i></button>
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th>Created At</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
<?php
$sql = "SELECT emp_salary.*, employees.emp_name
FROM emp_salary
LEFT JOIN employees
ON emp_salary.emp_id=employees.id
WHERE 1";
$rows = $db->query($sql);
foreach ($rows as $row) {
    echo <<<html
<tr>
    <td>{$row['id']}</td>
    <td>{$row['emp_name']}</td>
    <td>{$row['amount']}</td>
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
                    </div>
                    <?=$myfn->msg('msg'); ?>
                    <!-- changed content  ends-->
                </main>
                <!-- footer -->
                <?php require __DIR__.'/components/footer.php'; ?>
            </div>
        </div>
        <?php require __DIR__.'/components/script.php'; ?>
<script>
$(document).ready(function(){
  $('#hideForm').hide();
  $(document).on('click', '#buttonForm', function(){
    $('#hideForm').toggle(1000);
  }); 
});
</script>
    </body>
</html>
