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
        'emp_name'=> $db->escape($_POST['emp_name']),
        'designation'=> $db->escape($_POST['designation']),
        'shift'=> $db->escape($_POST['shift']),
        'nid'=> $db->escape($_POST['nid']),
        'phone'=> $db->escape($_POST['phone']),
        'image'=> $myfn->imageInsert('image'),
        'salary'=> $db->escape($_POST['salary']),
        'extra'=> $db->escape($_POST['extra']),
        'option_one'=> $db->escape($_POST['option_one']),
        'option_two'=> $db->escape($_POST['option_two']),
       
    ];
    $db->where ('id', $idtoupdate);
    if ($db->update ('employees', $data))
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
        $row = $db->getOne('employees');
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
                        <!-- <div class="mb-3 mt-3">
                            <input type="hidden" class="form-control" id="id"  name="id"  value="<?= $row['id'] ?>">
                        </div> -->
                        <div class="mb-3 mt-3">
                            <label for="emp_name" class="form-label">Employee Name:</label>
                            <input type="text" class="form-control" id="emp_name"  name="emp_name" value="<?= $row['emp_name'] ?>"required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="designation" class="form-label">Designation:</label>
                            <input type="text" class="form-control" id="designation"  name="designation" value="<?php echo $myfn->only_date($row['designation']); ?>"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="shift" class="form-label">Shift:</label>
                            <input type="text" class="form-control" id="shift"  name="shift" value="<?php echo $myfn->only_date($row['shift']); ?>"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="nid" class="form-label">National ID:</label>
                            <input type="number" class="form-control" id="nid"  name="nid" value="<?= $row['nid'] ?>"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="phone" class="form-label">Phone:</label>
                            <input type="text" class="form-control" id="nid"  name="phone" value="<?= $row['phone'] ?>"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="image" class="form-label">Image:</label>
                            <input type="file" class="form-control" id="image"  name="image">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="salary" class="form-label">Salary:</label>
                            <input type="number" class="form-control" id="salary"  name="salary" value="<?= $row['salary'] ?>"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="extra" class="form-label">Extra:</label>
                            <input type="text" class="form-control" id="extra"  name="extra" value="<?= $row['extra'] ?>"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="option_one" class="form-label">Option_one:</label>
                            <input type="text" class="form-control" id="option_one"  name="option_one" value="<?= $row['option_one'] ?>"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="option_two" class="form-label">Option_two:</label>
                            <input type="text" class="form-control" id="option_two"  name="option_two" value="<?= $row['option_two'] ?>"  required>
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
    
        
    