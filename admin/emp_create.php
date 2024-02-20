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
        'emp_name'=> $db->escape($_POST['emp_name']),
        'designation'=> $db->escape($_POST['designation']),
        'shift'=> $db->escape($_POST['shift']),
        'nid'=> $db->escape($_POST['nid']),
        'phone'=> $db->escape($_POST['phone']),
        'image'=> $myfn->imageInsert('image'),
        'salary'=> $db->escape($_POST['salary']),
        'extra'=> $db->escape($_POST['extra']),
        'option_one'=> $db->escape($_POST['option_one']),
        'option_two'=> $db->escape($_POST['option_two']),
    ];
    if($db->insert("employees", $data)){
        header("location: emp_all.php");
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
                    <?=$myfn->msg('msg'); ?>
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
        <section class="p-3 p-md-3 p-xl-5">
                                <div class="container">
                                  <div class="col-sm-7">
                                    <div class="card border-0 shadow-sm rounded-4">
                                      <div class="card-body">
                                        <div class="row">
                                          <form action="" method="post" class="row g-3 form" enctype="multipart/form-data">
                                            <h2 class="h2">Create Employee </h2><hr> 
                                            <div class="col-sm-3">
                                                <label for="emp_name">Employee Name:</label>
                                             </div>
                                            <div class="col-sm-8">
                                            <input type="text" class="form-control" id="emp_name"  name="emp_name" required>
                                              </div>
                                                <div class="col-sm-3">
                                                    <label for="designation">Designation:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <input type="text" class="form-control" id="designation"  name="designation"  required>
                                                </div>
                                                <div class="col-sm-3">
                                                <label for="shift">Shift:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <input type="text" class="form-control" id="shift"  name="shift"  required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="nid">National ID:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <input type="number" class="form-control" id="nid"  name="nid" required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="phone">Phone:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <input type="text" class="form-control" id="phone"  name="phone"  required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="image">Image:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <input type="file" class="form-control" id="image"  name="image"  required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="salary">Salary:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <input type="number" class="form-control" id="salary"  name="salary"  required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="extra">Extra:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <input type="text" class="form-control" id="extra"  name="extra"  required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="option_one">Option_one:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <input type="text" class="form-control" id="option_one"  name="option_one"   required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="option_one">Option_two:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <input type="text" class="form-control" id="option_two"  name="option_two"   required>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-secondary mb-3" name="submit" value="category">Create New Employee</button>
                                                </div>
                                             </form>
                                         </div>
                                       </div>
                                     </div>
                                  </div>
                                </div>
                            </section> 
                         </div>
        <?=$myfn->msg('msg');?>
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
    
        
    