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
if(isset($_POST['reg'])){
    $bill_id = $_POST['bill_id'];
    $bill_row = $db->where('id', $bill_id)->getOne('bills');
    $data = [
        'user_id'=> $db->escape($_POST['user_id']),
        'bill_id'=> $db->escape($bill_id),
        'amount'=> $bill_row['amount']
    ];
    if($db->insert("incomes",$data)){
        $message = "Done";
        //header("location: users_all.php");
    }else{
        $message = "Regitration failed!!";
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
                    <?php
        if(isset($message)) echo $message;
        ?>
        <hr>
        <div class="container p-4">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form action="" method="post">
                        <div class="mb-3 mt-3">
                            <input type="hidden" class="form-control" id="user_id"  name="user_id" value="<?=$_GET['id']; ?>" >
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="bill_id" class="form-label">Bill Name:</label>
                            <select class="form-control" id="bill_id"  name="bill_id"  required>
                                <option>select</option>
<?php
$bill_rows = $db->get("bills");
foreach($bill_rows as $bill_row){
    echo "<option value='{$bill_row['id']}'>{$bill_row['bill_name']}</option>";
}
?>                          
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="reg" value="submit" onClick="return comfarm()">Submit</button>
                    </form>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
        <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Bill ID</th>
                                        <th>Amount</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$rows = $db->where('user_id', $_GET['id'])->get('incomes');
foreach($rows as $row){
    $style = $row['status'] != 0 ? "green" : "red";
    echo <<<html
<tr style="background-color:{$style};">
    <td>{$row['id']}</td>
    <td>{$row['bill_id']}</td>
    <td>{$row['amount']}</td>
    <td>{$row['created_at']}</td>
    <td>
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Option</span>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="users_edit.php?id={$row['id']}">Payment</a></li>
                    <li><a class="dropdown-item" href="users_pass.php?id={$row['id']}">Delete</a></li>
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
    
        
    