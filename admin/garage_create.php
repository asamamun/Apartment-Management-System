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
      'gar_no'=> $db->escape($_POST['gar_no']),
      'user_id'=> $db->escape($_POST['user_id']),
  ];
  if($db->insert("garages",$data)){
      header("location: garage_all.php");
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
                                            <form action="" method="post" class="row g-3 form">
                                            <h2 class="h2">Create Garage</h2><hr>
                                                <div class="col-sm-3">
                                                <label for="user_id" class="form-label">User Name:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <select class="form-control" id="user_id"  name="user_id"  required>
<?php
$user_rows = $db->get("users");
foreach($user_rows as $user_row){
    echo "<option value='{$user_row['id']}'>{$user_row['name']}</option>";
}
?>
                                
                            </select>                       
                         </div>
                                                <div class="col-sm-3">
                                                <label for="gar_no" class="form-label">Garage No:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <input type="text" class="form-control" id="gar_no"  name="gar_no"  required>
                                                </div>
                                                
                                                
                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-secondary mb-3" name="submit" value="category">Create</button>
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
    
        
    