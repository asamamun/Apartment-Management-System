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
$sql = "SELECT apartments.*, users.* FROM apartments LEFT JOIN users ON apartments.user_id = users.id ORDER BY apartments.apt_no ASC";
$users = $db->query($sql);
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
                    <h1>Owner Info</h1><hr />
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Apartment Owner Info
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>APPT NO</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
// foreach($users as $user){
    // echo $user['name']."(".$user['email'].")<br>";
    // if($user['role'] == 0){
    //  $isblock = "<li><a class='dropdown-item' href='users_func.php?id={$user['id']}''>Unblock</a></li>";
     
//    }else{
//        $isblock = "<li><a class='dropdown-item' href='users_func.php?id={$user['id']}''>block</a></li>";
//     }
//{$isblock} 88 number line

    foreach($users as $user){
        if($user['role'] == 0){
            $rolesel= "<span class='text-warning'><b> Deactive </b></span>";}
    if($user['role'] == 2){
       $rolesel= "<span class='text-danger'><b> Admin </b></span>";
     
    }elseif($user['role'] == 1){
        $rolesel = "<span class='text-success '><b> User </b></span>";
   }
   
    
//    <td>{$user['role']}</td>
    echo <<<html
<tr>
    <td>{$user['id']}</td>
    <td>{$user['apt_no']}</td>
    <td>{$user['name']}</td>
    <td>{$user['email']}</td>
    <td> $rolesel</td>
    <td>{$user['created_at']}</td>
    <td>
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Option</span>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="users_edit.php?id={$user['id']}">Edit</a></li>
                    <li><a class="dropdown-item" href="users_pass.php?id={$user['id']}">Password</a></li>
                    <li><a class="dropdown-item" href="users_img.php?id={$user['id']}">Photo</a></li>
                    <li><a class="dropdown-item" href="users_mail.php?id={$user['id']}">Send Mail</a></li>
                    <li><a class="dropdown-item" href="users_profile.php?id={$user['id']}">Profile</a></li>
                    <li><a class="dropdown-item" href="users_payment.php?id={$user['id']}">Payment</a></li>
                    <li><a class="dropdown-item" href="users_role.php?id={$user['id']}">Role</a></li>
                    <li><a class="dropdown-item" href="users_delete.php?id={$user['id']}">Delete</a></li>
                </ul>
            </div>
        </div>
    </td>
</tr>
html;
}
?>
                                </tbody>
                    </table>
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