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
    $data = [
        'member_name'=> $db->escape($_POST['member_name']),
        'apt_id'=> $db->escape($_POST['apt_id']),
        'dob'=> $db->escape($_POST['dob']),
        'nid'=> $db->escape($_POST['nid']),
        'images'=> $myfn->imageInsert('images'),
    ];
    if($db->insert("apartment_members", $data)){
        header("location: mem_all.php");
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
                font-size: 1.2em;
            }
            .h2{
                text-align: center;
                color: gray;
            }
        </style>
        <hr>
        <section class="p-3 p-md-3 p-xl-5">
                                <div class="container">
                                    <div class="col-sm-7">
                                    <div class="card border-0 shadow-sm rounded-4">
                                        <div class="card-body">
                                        <div class="row">
                                            <form action="" method="post" class="row g-3 form" enctype="multipart/form-data">
                                            <h2 class="h2">Create member</h2><hr>
                                                <div class="col-sm-3">
                                                    <label for="apt_id">Apartments:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <select class="form-control" id="apt_id"  name="apt_id"  required>
<?php
$apt_rows = $db->orderBy('apt_no', 'ASC')->get("apartments");
foreach($apt_rows as $apt_row){
    echo "<option value='{$apt_row['id']}'>{$apt_row['apt_no']}</option>";
}
?>
                                
                            </select>                                     
                         </div>
                                                <div class="col-sm-3">
                                                    <label for="member_name">member_name:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="member_name" name="member_name" required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="dob">Date of Birth:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" id="dob" name="dob" required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="nid">National ID:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" id="nid" name="nid" required>
                                                </div>
                                                <div class="col-sm-3">
                                                <label for="image">Image:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <input type="file" class="form-control" id="image" name="images" >
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-secondary mb-3" name="submit" value="category">Create </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </section>
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
    
        
    