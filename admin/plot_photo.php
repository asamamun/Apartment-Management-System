<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';

use App\auth\Admin;

if (!Admin::Check()) {
    header('HTTP/1.1 503 Service Unavailable');
    exit;
}
$db = new MysqliDb();
$db->where('id', 1);
$row = $db->getOne('plot_info');
if (isset($_POST['submit'])) {
    $idtoupdate = $_POST['id'];
    $image_path_array = $row['image'].", ";
    $images = $_FILES["image"];
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
        'image' => $image_path_trim,
    ];
    $db->where('id', $idtoupdate);
    if ($db->update('plot_info', $data)){
        //$message = "Photo Updated successfully";
        //sleep(2);
        header("location: plot_photo.php");
        //exit;
    }else{
        $message = "Something went wrong, " . $db->getLastError();
    }
}
if(isset($_GET['delete_image'])){
    $rv = $_GET['delete_image'];
    $idtoupdate = $_GET['id'];
    $image_show = explode(', ', $row['image']);
    $key = array_search($rv, $image_show);
    unset($image_show[$key]);
    $update_image = implode(', ', $image_show);
    $data = [
        'image' => $update_image,
    ];
    $db->where('id', $idtoupdate);
    if ($db->update('plot_info', $data)){
        $message = "Photo Delete successfully";
        header("location: plot_photo.php");
    }else{
        $message = "Something went wrong, " . $db->getLastError();
    }
}
?>

<?php require __DIR__ . '/components/header.php'; ?>
</head>

<body class="sb-nav-fixed">
    <?php require __DIR__ . '/components/navbar.php'; ?>
    <div id="layoutSidenav">
        <?php require __DIR__ . '/components/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <!-- changed content -->
                <?php
                if (isset($message)) echo $message;
                ?>
                <h1>Image</h1>
                <hr>
                <div class="container p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="mb-3 mt-3">
                                    <input type="hidden" class="form-control" id="id" name="id" value="1">
                                </div>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="addImage()">Add Image</button>
                                <div class="mb-3 mt-3" id="imageArray">
                                    <input type="file" class="form-control mb-2" name="image[]" multiple>
                                </div>
                                <button type="submit" class="btn btn-primary" name="submit" value="update">Submit</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="row" >
<?php
if($row['image'] != ''){
$image_show = explode(', ', $row['image']);
    for ($i=0; $i < count($image_show); $i++) { 
        echo <<<html
<div class="col mb-4">
    <div class="card shadow-sm">
    <img src="{$image_show[$i]}" alt="..." width="100%" height="225">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
        <div class="btn-group">
            <a class="btn" href="{$image_show[$i]}">View</a>
            <a class="btn" href="?delete_image=$image_show[$i]&id={$row['id']}">Delete</a>
        </div>
        <small class="text-muted">9 mins</small>
        </div>
    </div>
    </div>
</div>       
html;
    }
}
?>   
                     
                            </div>
                        </div>
                    </div>
                </div>
                <!-- changed content  ends-->
            </main>
            <!-- footer -->
            <?php require __DIR__ . '/components/footer.php'; ?>
        </div>
    </div>
    <script src="<?= settings()['adminpage'] ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= settings()['adminpage'] ?>assets/js/scripts.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->
    <!-- <script src="<?= settings()['adminpage'] ?>assets/demo/chart-area-demo.js"></script> -->
    <!-- <script src="<?= settings()['adminpage'] ?>assets/demo/chart-bar-demo.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script> -->
    <!-- <script src="<?= settings()['adminpage'] ?>assets/js/datatables-simple-demo.js"></script> -->
    <script>
        function addImage() {
            $result = document.getElementById("imageArray").innerHTML;
            $result += `<input type="file" class="form-control mb-2" name="image[]" multiple>`;
            return document.getElementById("imageArray").innerHTML = $result;
        }
    </script>
</body>

</html>