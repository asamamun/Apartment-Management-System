<?php
$pagename = "jhdsfhkasj";
$pagetitle = "নতুন ব্যাবহারকারী তৈরী করুন খেয়াল রাখতে হবে সাবধানে ব্যাবহারকারীর টাইপ সিলেক্ট করতে হবে।";
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
$myfn = new myfn\myfn();
if(isset($_POST['reg'])){
  $data = [
      'name'=> $db->escape($_POST['username']),
      'phone'=> $db->escape($_POST['phone']),
      'email'=> $db->escape($_POST['email']),
      'role'=> $db->escape($_POST['role']),
      'status'=> 1,
      'address_one'=> $db->escape($_POST['address']),
      'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
  ];
  if($db->insert("users",$data)){
        $myfn->msg('msg',"Regitration Sucessfull!!");
        header("location: users_profile.php?id={$db->getInsertId()}");
  }else{
      $myfn->msg('msg',"Regitration failed!!");
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
                        <h1 class="mt-4"><?=$myfn->getPageName(__FILE__);?></h1>
                        <hr />
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><h5 style="color:green;"><?=$pagetitle; ?></h5></li>
                        </ol>
                        <div class="row">
                            <div class="col-md-8 border border-info rounded p-4">
                                <fieldset>
                                    <!-- <legend>Personalia:</legend> -->
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
                                            <div id="passwordHelpBlock" class="form-text">You Can not Change.</div>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="email" class="form-label">Email:</label>
                                            <input type="email" class="form-control" id="email"  name="email" required>
                                            <div id="passwordHelpBlock" class="form-text">Carefully input You Can not Change.</div>
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
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <img src="stroage/VV-Society-Logo.avif" alt="Admin" width="100%"/>
                            </div>
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
