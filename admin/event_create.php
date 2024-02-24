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
    $image_path_array = null;
    $images = $_FILES["images"];
    $count = count($images['name']);
    for($i=0; $i<$count; $i++){
        $img_name = $images['name'][$i];
        $img_size = $images['size'][$i];
        $img_temp = $images['tmp_name'][$i];
        $img_path = "stroage/img/".time().rand(1000000, 999999999).$img_name;
        $image_path_array .=  $img_path.", ";
        move_uploaded_file($img_temp, $img_path);
    }
    $image_path_trim = trim($image_path_array, ", ");
    $data = [
        'smt_id'=> $_SESSION["userid"],
        'title'=> $db->escape($_POST['title']),
        'details'=> $db->escape($_POST['details']),
        'images'=> $image_path_trim,
        'pinned'=> $db->escape($_POST['role']),
    ];
    if($db->insert('events', $data)){
        $myfn->msg('msg', 'done');
        header("location: event_all.php");
        exit;
    }else{
        $myfn->msg('msg', 'fail');
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
                                            <form action="" method="post" class="row g-3 form" enctype="multipart/form-data">
                                            <h3 class="h3">Create Event</h3><hr>    
                                            <div class="col-sm-3">
                                                    <label for="title">Title :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="title" name="title" required>
                                                </div>
                                                <div class="col-sm-3">
                                                <label for="details">Details :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" id="details" name="details"></textarea>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="image">Image :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="file" class="form-control" id="images" name="images[]" multiple required>
                                                </div>
                                                <div class="col-sm-3">
                                                <label for="role">Event Type :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <select name="role" id="role" class="form-select" required>
                                                    <option disabled selected>Open</option>
                                                    <option value="1">Pinned</option>
                                                    <option value="0">Unpinned</option>
                                                </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-secondary mb-3" name="submit" value="submit">Create</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </section>
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
    
        
    