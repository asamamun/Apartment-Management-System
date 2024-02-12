<?php
//date_default_timezone_set("Asia/Dhaka");
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
    $idtoupdate = $_POST['id'];
    $data = [
        'member_name'=> $db->escape($_POST['member_name']),
        'apt_id'=> $db->escape($_POST['apt_id']),
        'dob'=> $db->escape($_POST['dob']),
        'nid'=> $db->escape($_POST['nid']),
        'images'=> $myfn->imageInsert('images'),
    ];
    $db->where ('id', $idtoupdate);
    if ($db->update ('apartment_members', $data))
        $message = "User Updated successfully";
    else{
        $message = "Something went wrong, ".$db->getLastError();
    }
}
if(isset($_GET['id'])){
    $id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
    if($id){
        // $selectQuery = "select id,username,create_at from users where id=$id limit 1";
        // $result = $conn->query($selectQuery);
        // $row = $result->fetch_assoc();
        $db->where ('id', $id);
        $row = $db->getOne('apartment_members');
// var_dump($row);
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
                            <input type="hidden" class="form-control" id="id"  name="id"  value="<?= $row['id'] ?>">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="apt_id" class="form-label">Category Name:</label>
                            <select class="form-control" id="apt_id"  name="apt_id"  required>
<?php
$apt_rows = $db->get("apartments");
foreach($apt_rows as $apt_row){
    if($apt_row['id'] == $row['apt_id']){
        echo "<option value='{$apt_row['id']}' selected>{$apt_row['apt_no']}</option>";
    }else{
        echo "<option value='{$apt_row['id']}'>{$apt_row['apt_no']}</option>";
    }
}
?>
                                
                                </select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="member_name" class="form-label">Members Name:</label>
                            <input type="text" class="form-control" id="member_name"  name="member_name" value="<?= $row['member_name'] ?>"required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="dob" class="form-label">Date of Birth:</label>
                            <input type="date" class="form-control" id="dob"  name="dob" value="<?php echo $myfn->only_date($row['dob']); ?>"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="nid" class="form-label">National ID:</label>
                            <input type="number" class="form-control" id="nid"  name="nid" value="<?= $row['nid'] ?>"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="images" class="form-label">Image:</label>
                            <input type="file" class="form-control" id="images"  name="images">
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit" value="update">Update</button>
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
    
        
    