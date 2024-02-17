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
    $cat_name = $_POST['cat_name'];
    $data = [
        'cat_name' => $cat_name,
    ];
    $db->where ('id', $idtoupdate);
    if ($db->update ('categories', $data))
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
        $row = $db->getOne('categories');
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
                            <label for="cat_name" class="form-label">Category Name:</label>
                            <input type="text" class="form-control" id="cat_name"  name="cat_name"  value="<?= $row['cat_name'] ?>" required>
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
    
        
    