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
      'cat_name'=> $db->escape($_POST['cat_name']),
      'smt_id'=> $_SESSION["userid"],
      'type'=> $db->escape($_POST['cat_type']),
  ];
  if($db->insert("categories",$data)){
      header("location: cat_all.php");
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
                        <h1 class="mt-4">Category Create</h1>
                        <hr />
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><h3><?=$pagetitle;?></h3></li>
                        </ol>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8 border border-info rounded p-4">
                                <form action="" method="post">
                                    <div class="mb-3 mt-3">
                                        <label for="cat_name" class="form-label">Category Name:</label>
                                        <input type="text" class="form-control" id="cat_name"  name="cat_name"  required>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="cat_type" class="form-label">Category Type:</label>
                                        <select class="form-control" id="cat_type"  name="cat_type"  required>
                                            <option>Select</option>
                                            <option value="1">income</option>
                                            <option value="0">expense</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit" value="category">Create New Category</button>
                                </form>
                            </div>
                            <div class="col-md-2"></div>
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
