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
if(isset($_POST['reg'])){
  $data = [
      'name'=> $db->escape($_POST['username']),
      'phone'=> $db->escape($_POST['phone']),
      'email'=> $db->escape($_POST['email']),
      'role'=> $db->escape($_POST['role']),
      'address_one'=> $db->escape($_POST['address']),
      'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
  ];
  if($db->insert("users",$data)){
      header("location: users_all.php");
  }
  else{
      $message = "Regitration failed!!";
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
                    <form action="" method="post">
                        <div class="mb-3 mt-3">
                            <input type="hidden" class="form-control" id="id"  name="id" >
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="username" class="form-label">User Name:</label>
                            <input type="text" class="form-control" id="username"  name="username"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="phone" class="form-label">Phone:</label>
                            <input type="phone" class="form-control" id="phone"  name="phone" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email"  name="email" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="password" class="form-label">password:</label>
                            <input type="password" class="form-control" id="password"  name="password" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="role" class="form-label">Type:</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="1">User</option>
                                <option value="2">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="address" class="form-label">Address:</label>
                            <textarea class="form-control" name="address" id="address"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="reg" value="submit">Submit</button>
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
    
        
    