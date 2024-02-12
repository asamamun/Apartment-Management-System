<?php
date_default_timezone_set("Asia/Dhaka");
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
if(isset($_POST['submit'])){
  $data = [
        'cat_id'=> $db->escape($_POST['cat_id']),
        'sub_id'=> $db->escape($_POST['sub_id']),
        'amount'=> $db->escape($_POST['amount']),
        'details'=> $db->escape($_POST['details']),
  ];
  if($db->insert("bill_items",$data)){
      header("location: bill_item_all.php");
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
                    <?php
        if(isset($message)) echo $message;
        ?>
        <div class="container p-4">
            <h1 class="mt-4">Dashboard</h1>
            <hr />
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form action="" method="post">
                        <div class="mb-3 mt-3">
                            <label for="cat_id" class="form-label">Category (optional)</label>
                            <select class="form-control" id="cat_id" name="cat_id" onChange="getApi('cat_id', 'sub_id')">
                                <option>select</option>
<?php
$db->where('type', 1);
$div_rows = $db->get("categories");
foreach ($div_rows as $div_row) {
    echo "<option value='{$div_row['id']}'>{$div_row['cat_name']}</option>";
}
?>
                            </select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="sub_id" class="form-label">Sub Category (optional)</label>
                            <select class="form-control" id="sub_id" name="sub_id"></select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="text" class="form-control" id="amount"  name="amount"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="details" class="form-label">Details (optional)</label>
                            <textarea class="form-control" id="details"  name="details"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit" value="category">Income Item Set</button>
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
<script>
function getApi(get, set) {
    let str = document.getElementById(get).value;
    let url = "bill_item_api.php?id=" + str + "&set=" + set + "&get=" + get;
    //fetch(url).then(res => res.text()).then(data => {document.getElementById(set).innerHTML = data;});
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
      document.getElementById(set).innerHTML = this.responseText;
      //alert(this.responseText);
    }
    xmlhttp.open("GET", url);
    xmlhttp.send();
}
</script>
    </body>
</html>
    
        
    