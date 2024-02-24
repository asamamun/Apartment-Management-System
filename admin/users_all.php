<?php
$pagename = "jhdsfhkasj";
$pagetitle = "Housing Society";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
use App\auth\Admin;
if(!Admin::Check()){
    header('HTTP/1.1 503 Service Unavailable');
    exit;
}
$myfn = new myfn\myfn();
$db = new MysqliDb ();
if(isset($_GET["role"])){
    $db->where('role', $_GET["role"]);
}
if(isset($_GET["status"])){
    $db->where('status', $_GET["status"]);
}
$users = $db->get('users');
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
                            <li class="breadcrumb-item active"><?=$pagetitle; ?></li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <a class="btn btn-primary" href="users_create.php"><i class="fas fa-plus"></i></a>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
<?php
foreach($users as $user){
    $isblock = null;
    if($user['role'] == 0){
        $isblock = "<a class='dropdown-item' href='users_func.php?block_id={$user['id']}&role=1'>Unblock</a>";
    }else{
        $isblock = "<a class='dropdown-item' href='users_func.php?block_id={$user['id']}&role=0'><i class='bi bi-ban'></i> block</a>";
    }
    echo <<<html
<tr>
    <td>{$user['id']}</td>
    <td>{$user['name']}</td>
    <td>{$user['email']}</td>
    <td>{$user['created_at']}</td>
    <td>
        <div class="btn btn-group" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Option</span>
                <ul class="dropdown-menu" style="background-color:#E0E3EA">
                    <li><a class="dropdown-item" href="users_edit.php?id={$user['id']}"><i class="bi bi-pencil-square"></i> Edit</a></li>
                    <li><a class="dropdown-item" href="users_pass.php?id={$user['id']}"><i class="bi bi-lock-fill"></i> Password</a></li>
                    <li><a class="dropdown-item" href="users_img.php?id={$user['id']}"><i class="bi bi-file-earmark-image"></i> Photo</a></li>
                    <li><a class="dropdown-item" href="users_mail.php?id={$user['id']}"><i class="bi bi-envelope"></i> Send Mail</a></li>
                    <li><a class="dropdown-item" href="users_profile.php?id={$user['id']}"><i class="bi bi-person-bounding-box"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="users_bills.php?id={$user['id']}"><i class="bi bi-credit-card-2-back-fill"></i> Bills</a></li>
                    <li>{$isblock}</li>
                    <li><a class="dropdown-item" href="users_delete.php?id={$user['id']}" onClick="return confirm('Are You Sure To Delete File.')"><i class="bi bi-archive-fill"></i> Delete</a></li>
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
                    <!-- changed content  ends-->
                    <?=$myfn->msg('msg'); ?>
                </main>
<!-- footer -->
<?php require __DIR__.'/components/footer.php'; ?>
            </div>
        </div>
        <?php require __DIR__.'/components/script.php'; ?>
    </body>
</html>
