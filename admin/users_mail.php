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
    $id = $_POST['id'];
    $db->where('id', $id);
    $row = $db->getOne('users');
    $email = $row['email'];
    $title = $_POST['title'];
    $msg = $_POST['massage'];
    $myfn->msg('msg', "email send to $email");
    //mail($email, $title, $msg);
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
                        <h1 class="mt-4"><?=$myfn->getPageName(__FILE__);?></h1>
                        <hr />
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <form action="" method="post">
                                    <div class="mb-3 mt-3">
                                        <input type="hidden" class="form-control" id="id"  name="id" value="<?=$_GET['id']; ?>">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="title" class="form-label">Title:</label>
                                        <input type="text" class="form-control" id="title"  name="title"  required>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="massage" class="form-label">Message:</label>
                                        <textarea class="form-control" name="massage" id="massage"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit" value="send">Send</button>
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
