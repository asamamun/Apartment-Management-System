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
$myfn = new myfn\myfn;
$db = new MysqliDb ();
$vst_rows = $db->get('apartments');
$vst_arr = array();
foreach($vst_rows as $vst_value){
    $vst_arr[$vst_value['id']] = $vst_value['apt_no'];
}
$sql = "SELECT * FROM `visitors` WHERE entry_time >= curdate()";
$rows = $db->query($sql);
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
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>apt_id</th>
                                            <th>visitor_name</th>
                                            <th>persons</th>
                                            <th>phone</th>
                                            <th>entry_time</th>
                                            <th>exit_time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>id</th>
                                            <th>apt_id</th>
                                            <th>visitor_name</th>
                                            <th>persons</th>
                                            <th>phone</th>
                                            <th>entry_time</th>
                                            <th>exit_time</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
<?php
foreach($rows as $row){
    if($row['exit_time'] == null){
        $ifnull="style='background-color:red'";
        $extButton = "<td><a class='btn btn-info' href='visitor_func.php?id={$row['id']}&func=exit_func'>Exit</a></td>";
    }else{
        $ifnull="style='background-color:green'";
        $extButton = "<td></td>";
    }
    echo <<<html
<tr {$ifnull}>
    <td>{$row['id']}</td>
    <td>{$vst_arr[$row['apt_id']]}</td>
    <td>{$row['visitor_name']}</td>
    <td>{$row['persons']}</td>
    <td>{$row['phone']}</td>
    <td>{$row['entry_time']}</td>
    <td>{$row['exit_time']}</td>
    {$extButton}
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
