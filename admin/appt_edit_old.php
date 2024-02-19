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
if(isset($_POST['submit'])){
    $idtoupdate = $_POST['id'];
    // $apt_no = $_POST['apt_no'];
    $data = [
        'apt_no' => $_POST['apt_no'],
        'user_id' => $_POST['user_id'],
        'flat_size'=> $db->escape($_POST['flat_size']),
        'info'=> $db->escape($_POST['info'])
    ];
    $db->where ('id', $idtoupdate);
    if ($db->update ('apartments', $data))
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
        $row = $db->getOne('apartments');
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
                            <label for="user_id" class="form-label">User Name:</label>
                            <select class="form-control" id="user_id"  name="user_id"  required>
<?php
$user_rows = $db->get("users");
foreach($user_rows as $user_row){
    if($user_row['id'] == $row['user_id']){
        echo "<option value='{$user_row['id']}' selected>{$user_row['name']}</option>";
    }else{
        echo "<option value='{$user_row['id']}'>{$user_row['name']}</option>";
    }
}
?>
                                
                            </select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="apt_no" class="form-label">Appartment No:</label>
                            <input type="text" class="form-control" id="apt_no"  name="apt_no"  value="<?= $row['apt_no'] ?>" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="flat_size" class="form-label">Flat Size:</label>
                            <input type="text" class="form-control" id="flat_size"  name="flat_size" value="<?= $row['flat_size'] ?>">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="info" class="form-label">Info:</label>
                            <textarea class="form-control" id="info"  name="info"><?= $row['info'] ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit" value="update">Submit</button>
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
    
        
    