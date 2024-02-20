<?php
$pagename = "jhdsfhkasj";
$pagetitle = "";
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
$myfn = new myfn\myfn;
$db = new MysqliDb ();
$emp_rows = $db->get('employees');
$mem_arr = array();
foreach($emp_rows as $emp_value){
    $emp_arr[$emp_value['id']] = $emp_value['emp_name'];
}
$rows = $db->orderBy('emp_name', 'ASC')->get('employees');
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
                            <li class="breadcrumb-item active"><h3><?=$pagetitle;?></h3></li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <a class="btn btn-primary" href="cat_create.php"><i class="fas fa-plus"></i></a>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>emp_name</th>
                                            <th>designation</th>
                                            <th>shift</th>
                                            <th>nid</th>
                                            <th>phone</th>
                                            <th>image</th>
                                            <th>joindate</th>
                                            <th>salary</th>
                                            <th>extra</th>
                                            <th>option_one</th>
                                            <th>option_two</th>
                                            <th>created_at</th>
                                            <th>status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>id</th>
                                            <th>emp_name</th>
                                            <th>designation</th>
                                            <th>shift</th>
                                            <th>nid</th>
                                            <th>phone</th>
                                            <th>image</th>
                                            <th>joindate</th>
                                            <th>salary</th>
                                            <th>extra</th>
                                            <th>option_one</th>
                                            <th>option_two</th>
                                            <th>created_at</th>
                                            <th>status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
foreach($rows as $row){
    // echo $user['name']."(".$user['email'].")<br>";
    echo <<<html
<tr>
    <td>{$row['id']}</td>
    <td>{$row['emp_name']}</td>
    <td>{$row['designation']}</td>
    <td>{$row['shift']}</td>
    <td>{$row['nid']}</td>
    <td>{$row['phone']}</td>
    <td><img src="{$row['image']}" width="40" height="40"/></td>
    <td>{$row['salary']}</td>
    <td>{$row['extra']}</td>
    <td>{$row['option_one']}</td>
    <td>{$row['option_two']}</td>
    <td>{$row['option_two']}</td>
    <td>{$row['created_at']}</td>
    <td>{$row['status']}</td>
    <td>
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">option</span>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="emp_edit.php?id={$row['id']}">Edit</a></li>
                    <li><a class="dropdown-item" href="emp_delete.php?id={$row['id']}">Delete</a></li>
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
