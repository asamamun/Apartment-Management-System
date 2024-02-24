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
$myfn = new myfn\myfn();
$db = new MysqliDb ();
if(isset($_POST['submit'])){
  $data = [
        'smt_id'=> $_SESSION["userid"],
        'cat_id'=> $db->escape($_POST['cat_id']),
        'sub_id'=> $db->escape($_POST['sub_id']),
        'smt_id'=> $_SESSION['userid'],
        'amount'=> $db->escape($_POST['amount']),
        'details'=> $db->escape($_POST['details']),
  ];
  if($db->insert("expences",$data)){
        $myfn->msg('msg', 'imsert Done.');
        header("location: expanse_all.php");
        exit;
  }
  else{
    $myfn->msg('msg', 'server problem.');
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
                            <li class="breadcrumb-item active">সাবধানে এন্টি করবেন পরে এডিট করা মুশকিল।</li>
                        </ol>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <form action="" method="post">
                                    <div class="mb-3 mt-3">
                                        <label for="cat_id" class="form-label">Expanse Category</label>
                                        <select class="form-control" id="cat_id" name="cat_id" onChange="getApi('cat_id', 'sub_id')">
                                            <option>select</option>
<?php
$db->where('type', 0);
$div_rows = $db->get("categories");
foreach ($div_rows as $div_row) {
    echo "<option value='{$div_row['id']}'>{$div_row['cat_name']}</option>";
}
?>
                                        </select>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="sub_id" class="form-label">Expanse Sub Category</label>
                                        <select class="form-control" id="sub_id" name="sub_id"></select>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="amount" class="form-label">Amount</label>
                                        <input type="text" class="form-control" id="amount"  name="amount"  required>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <!-- <label for="details" class="form-label">Details</label> -->
                                        <textarea class="form-control" id="textarea"  name="details"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit" value="category">Income Item Set</button>
                                </form>
                            </div>
                            <div class="col-md-2"></div>
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
