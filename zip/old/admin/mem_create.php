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
        'member_name'=> $db->escape($_POST['member_name']),
        'apt_no'=> $db->escape($_POST['apt_no']),
        'dob'=> $db->escape($_POST['dob']),
        'nid'=> $db->escape($_POST['nid']),
        'image'=> $myfn->imageInsert('image'),
    ];
    if($db->insert("appt_members", $data)){
        header("location: mem_all.php");
    }
else{
    $message = "insert failed!!";
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
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3 mt-3">
                            <label for="apt_no" class="form-label">Apartments:</label>
                            <select class="form-control" id="apt_no"  name="apt_no"  required>
<?php
$apt_rows = $db->get("apartments");
foreach($apt_rows as $apt_row){
    echo "<option value='{$apt_row['id']}'>{$apt_row['apt_no']}</option>";
}
?>
                                
                            </select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="member_name" class="form-label">Members Name:</label>
                            <input type="text" class="form-control" id="member_name"  name="member_name"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="dob" class="form-label">Date of Birth:</label>
                            <input type="date" class="form-control" id="dob"  name="dob"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="nid" class="form-label">National ID:</label>
                            <input type="number" class="form-control" id="nid"  name="nid"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="image" class="form-label">Image:</label>
                            <input type="file" class="form-control" id="image"  name="image">
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit" value="">Create New Members</button>
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
    
        
    