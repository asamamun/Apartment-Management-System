<?php
$pagename = "jhdsfhkasj";
$pagetitle = "";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
$myfn = new myfn\myfn();
use App\auth\Admin;
if(!Admin::Check()){
    header('HTTP/1.1 503 Service Unavailable');
    exit;
}
$db = new MysqliDb ();
if(isset($_POST['submit'])){
  $data = [
      'sub_name'=> $db->escape($_POST['sub_name']),
      'cat_id'=> $db->escape($_POST['cat_id']),
      'type' => $db->escape($_POST['sub_type'])
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
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Sub-Category Create</h1>
                        <hr />
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><h3><?=$pagetitle;?></h3></li>
                        </ol>
                        <div class="row mb-4">
                            <div class="col-md-2"></div>
                            <div class="col-md-8 border border-info rounded p-4">
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
                                    <div class="mb-3 mt-3">
                                        <label for="sub_type" class="form-label">Sub Category Type:</label>
                                        <select class="form-control" id="sub_type"  name="sub_type"  required>
                                            <option>Select</option>
                                            <option value="1">income</option>
                                            <option value="0">expense</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit" value="">Create New Sub Category</button>
                                </form>
                            </div>
                            <div class="col-md-2"></div>
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
    </body>
</html>
