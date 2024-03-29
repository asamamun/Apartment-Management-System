<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
$myfn = new myfn\myfn;
use App\auth\Admin;
if(!Admin::Check()){
    header('HTTP/1.1 503 Service Unavailable');
    exit;
}
$db = new MysqliDb ();
if(isset($_GET['id'])){
    $id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
    if($id){
        $db->where ('id', $id);
        $row = $db->getOne('events');
    }     
}
if(isset($_POST['submit'])){
    $idtoupdate = $_POST['id'];
    $data = [
        'title'=> $db->escape($_POST['title']),
        'details'=> $db->escape($_POST['details']),
        'images'=> isset($_FILES['images']['name']) && $_FILES['images']['name'] != "" ? $myfn->imageInsert('images') : $row['image'],
        'pinned'=> $db->escape($_POST['role']),
    ];
    $db->where ('id', $idtoupdate);
    if($db->update('events', $data)){
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
                                    <div class="col-sm-7" style="display: inline-block;">
                                    <div class="card border-0 shadow-sm rounded-4">
                                        <div class="card-body">
                                        <div class="row">
                                            <form action="" method="post" class="row g-3 form" enctype="multipart/form-data">
                                            <h3 class="h3">Update Event</h3><hr>    
                                            <input type="hidden" class="form-control" id="id" name="id" value="<?= $row['id'] ?>" required>
                                            <div class="col-sm-3">
                                                    <label for="title">Title :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="title" name="title" value="<?= $row['title'] ?>" required>
                                                </div>
                                                <div class="col-sm-3">
                                                <label for="details">Details :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" id="details" name="details"><?= $row['details'] ?></textarea>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="image">Image :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="file" class="form-control" id="image" name="image">
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
                                <div class="col-sm-5 mt-3" style="float: right;">
                                    <div class="card border-0 shadow-sm rounded-4">
                                        <div class="card-body">
<?php
if($row['images'] != ''){
$image_show = explode(', ', $row['images']);
    for ($i=0; $i < count($image_show); $i++) { 
        echo <<<html
<div class="col mb-4">
    <div class="card shadow-sm">
    <img src="{$image_show[$i]}" alt="..." width="100%" height="225">
    </div>
</div>       
html;
    }
}
?> 
                                            <img src="<?=$row['images']; ?>" width="100%" height="300"/>
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
    
        
    