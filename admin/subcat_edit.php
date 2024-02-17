<?php
$pagename = "jhdsfhkasj";
$pagetitle = "";
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
    $data = [
        'sub_name' => $db->escape($_POST['sub_name']),
        'cat_id' => $db->escape($_POST['cat_id']),
        'type' => $db->escape($_POST['sub_type'])
    ];
    $db->where ('id', $idtoupdate);
    if ($db->update ('sub_categories', $data))
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
        $row = $db->getOne('sub_categories');
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
                    <div class="container p-4">
                        <h1 class="mt-4">Category Edit</h1>
                            <hr />
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active"><h3><?=$pagetitle;?></h3></li>
                            </ol>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8 border border-info rounded p-4">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="mb-3 mt-3">
                                            <input type="hidden" class="form-control" id="id"  name="id"  value="<?= $row['id'] ?>">
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="cat_id" class="form-label">Category Name:</label>
                                            <select class="form-control" id="cat_id"  name="cat_id"  required>
<?php
$cat_rows = $db->get("categories");
foreach($cat_rows as $cat_row){
    if($cat_row['id'] == $row['cat_id']){
        echo "<option value='{$cat_row['id']}' selected>{$cat_row['cat_name']}</option>";
    }else{
        echo "<option value='{$cat_row['id']}'>{$cat_row['cat_name']}</option>";
    }
}
?>
                                            
                                            </select>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="sub_name" class="form-label">sub category Name:</label>
                                            <input type="text" class="form-control" id="sub_name"  name="sub_name"  value="<?= $row['sub_name'] ?>" required>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="sub_type" class="form-label">Sub Category Type:</label>
                                            <select class="form-control" id="sub_type"  name="sub_type"  required>
                                                <option value="1" <?= $row['type'] == 1 ? "selected" : ''; ?>>income</option>
                                                <option value="0" <?= $row['type'] == 0 ? "selected" : ''; ?>>expense</option>
                                            </select>
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
    
        
    