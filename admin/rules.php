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
$myfn = new myfn\myfn();
$db = new MysqliDb ();
if(isset($_POST['submit'])){
    $idtoupdate = $_POST['id'];
    $data = [
        'title' => $_POST['title'],
        'details' => $_POST['details']
    ];
    $db->where ('id', $idtoupdate);
    if ($db->update ('rules', $data))
        $message = "Updated successfully";
    else{
        $message = "Something went wrong, ".$db->getLastError();
    }
}
    $db->where ('id', 1);
    $row = $db->getOne('rules');
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
                        <h1 class="mt-4"><?=$myfn->getPageName(__FILE__);?></h1>
                        <hr />
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="mb-3 mt-3">
                                        <input type="hidden" class="form-control" id="id"  name="id"  value="1">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="title" class="form-label">Title:</label>
                                        <input type="text" class="form-control" id="title"  name="title"  value="<?= $row['title'] ?>" required>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="details" class="form-label">Details:</label>
                                        <textarea class="form-control" id="textarea"  name="details"><?=$row['details']; ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit" value="update">Update</button>
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
