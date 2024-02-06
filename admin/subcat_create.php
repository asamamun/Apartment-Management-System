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
  $data = [
      'sub_name'=> $db->escape($_POST['sub_name']),
      'cat_id'=> $db->escape($_POST['cat_id'])
  ];
  if($db->insert("sub_categories", $data)){
      header("location: subcat_all.php");
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
                    <form action="" method="post">
                        <div class="mb-3 mt-3">
                            <label for="cat_id" class="form-label">Category Name:</label>
                            <select class="form-control" id="cat_id"  name="cat_id"  required>
<?php
$cat_rows = $db->get("categories");
foreach($cat_rows as $cat_row){
    echo "<option value='{$cat_row['id']}'>{$cat_row['cat_name']}</option>";
}
?>
                                
                            </select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="sub_name" class="form-label">Sub Category Name:</label>
                            <input type="text" class="form-control" id="sub_name"  name="sub_name"  required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit" value="">Create New Sub Category</button>
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
    
        
    