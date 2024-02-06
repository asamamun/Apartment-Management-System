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
$db = new MysqliDb ();
if(isset($_POST['username'])){
    $idtoupdate = $_POST['id'];
    $username = $_POST['username'];
    $role = $_POST['role'];
    $mobile = $_POST['mobile'];
    $address_one = $_POST['address_one'];
    $address_two = $_POST['address_two'];
    $data = [
        'name' => $username,
        'role' => $role,
        'mobile' => $mobile,
        'address_one' => $address_one,
        'address_two' => $address_two,
    ];
    $db->where ('id', $idtoupdate);
    if ($db->update ('users', $data))
        $message = "User Updated successfully";
    else{
        $message = "Something went wrong, ".$db->getLastError();
    }
}
if(isset($_GET['id'])){
    $id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
    if($id){
        // $selectQuery = "select id,username,create_at from users where id=$id limit 1";
        // $result = $conn->query($selectQuery);
        // $row = $result->fetch_assoc();
        $db->where ('id', $id);
        $row = $db->getOne('users');
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
                    <?php
        if(isset($message)) echo $message;
        ?>
        <hr>
        <div class="container p-4">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3 mt-3">
                            <input type="hidden" class="form-control" id="id"  name="id"  value="<?= $row['id'] ?>">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="username" class="form-label">User Name:</label>
                            <input type="text" class="form-control" id="username"  name="username"  value="<?= $row['name'] ?>" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control bg-secondary" id="email"  name="email"  value="<?= $row['email'] ?>" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="phone" class="form-label">Phone:</label>
                            <input type="phone" class="form-control bg-secondary" id="phone"  name="phone"  value="<?= $row['phone'] ?>" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="mobile" class="form-label">Mobile:</label>
                            <input type="phone" class="form-control" id="mobile"  name="mobile"  value="<?= $row['mobile'] ?>" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="pass2" class="form-label">Type:</label>
                            <select name="role" id="role" class="form-control">
                                <option value="1" <?= ($row['role'] =="1")?"selected":"" ?>>User</option>
                                <option value="2" <?= ($row['role'] =="2")?"selected":"" ?>>Admin</option>
                            </select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="address_one" class="form-label">Address one:</label>
                            <textarea class="form-control" name="address_one" id="address_one" require><?= $row['address_one'] ?></textarea>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="address_two" class="form-label">Address two:</label>
                            <textarea class="form-control" name="address_two" id="address_two"><?= $row['address_two'] ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="col-md-2"></div>
            </div>
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
    
        
    