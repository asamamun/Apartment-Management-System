<?php
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
    $idtoupdate = $_POST['id'];
    // $apt_no = $_POST['apt_no'];
    $data = [
        'smt_id'=> $_SESSION["userid"],
        'decision' => $_POST['decision'],
    ];
    $db->where('id', $idtoupdate);
    if($db->update('complain', $data)){
        $myfn->msg('msg', 'done');
        header("location: complain_all.php");
        exit;
    }else{
        $myfn->msg('msg', 'fail');
    }
}
if(isset($_GET['id'])){
    $id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
    if($id){
        // $selectQuery = "select id,username,create_at from users where id=$id limit 1";
        // $result = $conn->query($selectQuery);
        // $row = $result->fetch_assoc();
        $db->where ('id', $id);
        $row = $db->getOne('complain');
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
        <style> 
    .form{
        background-color: mintcream;
        border-radius: 5px;
        box-shadow: -4px 3px 11px 0px rgba(0,0,0,0.75);
    }
    label{
        font-weight: bold;
        font-size: 1.1em;
    }
    .h3{
        text-align: center;
        color: gray;
    }
</style>
        <section class="p-3 p-md-3 p-xl-5">
                                <div class="container">
                                    <div class="col-sm-7">
                                    <div class="card border-0 shadow-sm rounded-4">
                                        <div class="card-body">
                                        <div class="row">
                                            <form action="" method="post" class="row g-3 form">
                                            <h3 class="h3">Complain Decision</h3><hr>
                                            <input type="hidden" class="form-control" id="id" name="id" value="<?= $row['id'] ?>" required>
                                                <div class="col-sm-3">
                                                <label for="decision">Decision :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" id="decision" name="decision"></textarea>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-secondary mb-3" name="submit">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </section>
        <!-- changed content  ends-->
        <?=$myfn->msg('msg'); ?>
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
    
        
    