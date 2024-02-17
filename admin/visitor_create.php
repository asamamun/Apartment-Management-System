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
if(isset($_POST['submit'])){
    $data = [
        'visitor_name'=> $db->escape($_POST['visitor_name']),
        'apt_id'=> $db->escape($_POST['apt_id']),
        'address'=> $db->escape($_POST['address']),
        'persons'=> $db->escape($_POST['persons']),
        'phone'=> $db->escape($_POST['phone']),
        'purpose'=> $db->escape($_POST['purpose'])
    ];
    if($db->insert("visitors", $data)){
        $myfn->msg('msg', "Dane");
        header("location: visitor_today.php");
    }
else{
    $myfn->msg('msg', "insert failed!!");
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
        <?=$myfn->msg('msg'); ?>
        ?>
        <hr>
        <div class="container p-4">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3 mt-3">
                            <label for="apt_id" class="form-label">Apartments:</label>
                            <select class="form-control" id="apt_id"  name="apt_id"  required>
<?php
$apt_rows = $db->orderBy('apt_no', 'ASC')->get("apartments");
foreach($apt_rows as $apt_row){
    echo "<option value='{$apt_row['id']}'>{$apt_row['apt_no']}</option>";
}
?>
                                
                            </select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="visitor_name" class="form-label">Visitor Name:</label>
                            <input type="text" class="form-control" id="visitor_name"  name="visitor_name"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="address" class="form-label">Address:</label>
                            <input type="text" class="form-control" id="address"  name="address"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="persons" class="form-label">Persons:</label>
                            <input type="text" class="form-control" id="persons"  name="persons"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="phone" class="form-label">Phone:</label>
                            <input type="text" class="form-control" id="phone"  name="phone">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="purpose" class="form-label">Purpose:</label>
                            <input type="text" class="form-control" id="purpose"  name="purpose">
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit" value="">Entry</button>
                    </form>
                </div>
                <div class="col-md-2"></div>
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
    
        
    