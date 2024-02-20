<?php
//date_default_timezone_set("Asia/Dhaka");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
$myfn = new myfn\myfn();

use App\auth\Admin;

if (!Admin::Check()) {
    header('HTTP/1.1 503 Service Unavailable');
    exit;
}
$db = new MysqliDb();
if (isset($_POST['submit'])) {
    
    echo $_POST['dob'];
    $idtoupdate = $_POST['id'];
    $data = [
        'member_name' => $db->escape($_POST['member_name']),
        'apt_id' => $db->escape($_POST['apt_id']),
        'dob' => $db->escape($_POST['dob']),
        'nid' => $db->escape($_POST['nid']),
        'images' => $myfn->imageInsert('images'),
    ];
    $db->where('id', $idtoupdate);
    if ($db->update('apartment_members', $data)) {
        $myfn->msg('msg', 'done');
        header("location:mem_all.php");
        exit;
    } else {
        $myfn->msg('msg', 'fail');
    }
}
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if ($id) {
        // $selectQuery = "select id,username,create_at from users where id=$id limit 1";
        // $result = $conn->query($selectQuery);
        // $row = $result->fetch_assoc();
        $db->where('id', $id);
        $row = $db->getOne('apartment_members');
        // var_dump($row);
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
                <div class="container-fluid px-4">
                    <?php
                    if (isset($message)) echo $message;
                    ?>
                    <style>
                        .form {
                            background-color: mintcream;
                            border-radius: 5px;
                            box-shadow: -4px 3px 11px 0px rgba(0, 0, 0, 0.75);
                        }

                        label {
                            font-weight: bold;
                            font-size: 1.2em;
                        }
                        .h2{
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
                                            <h2 class="h2">Update Members info</h2><hr>
                                          <div class="col-sm-11">
                                                    <input type="hidden" class="form-control" id="id" name="id" value="<?= $row['id'] ?>">                                          
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="apt_id">Category Name:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <select class="form-control" id="apt_id" name="apt_id" required>
                                        <?php
                                        $apt_rows = $db->get("apartments");
                                        foreach ($apt_rows as $apt_row) {
                                            if ($apt_row['id'] == $row['apt_id']) {
                                                echo "<option value='{$apt_row['id']}' selected>{$apt_row['apt_no']}</option>";
                                            } else {
                                                echo "<option value='{$apt_row['id']}'>{$apt_row['apt_no']}</option>";
                                            }
                                        }
                                        ?>

                                    </select>
                                                </div>
                                                <div class="col-sm-3">                                           
                                                    <label for="member_name">Members Name:</label>
                                                </div>
                                                <div class="col-sm-8">             
                                                    <input type="text" class="form-control" id="member_name" name="member_name" value="<?= $row['member_name'] ?>" required>
                                                </div>



                                                <div class="col-sm-3">
                                                    <label for="dob">Date of Birth:</label>        
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $myfn->inputDate($row['dob']); ?>" required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="nid">National ID:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <input type="number" class="form-control" id="nid" name="nid" value="<?= $row['nid'] ?>" required>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-secondary mb-3" name="submit" value="update">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <?= $myfn->msg('msg'); ?>
            
                <!-- changed content  ends-->
            </main>
            <!-- footer -->
            <?php require __DIR__ . '/components/footer.php'; ?>
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