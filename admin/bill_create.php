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
try{
    $db->startTransaction();
    if(isset($_POST['submit'])){
        $items_id = $_POST['items_id'];
        $amount = 0;
        for ($i=0; $i < count($items_id); $i++) { 
            $re = $db->where('id', $items_id[$i])->getOne('bill_items');
            $amount += $re['amount'];
        }
        $items_string = implode (', ', $items_id);
        $data = [
                'bill_name'=> $db->escape($_POST['bill_name']),
                'items_id'=> $items_string,
                'amount'=> $amount
            ];
        if($db->insert("bills", $data)){
            if(isset($_POST['send_all']) && $_POST['send_all'] == 1){
                $lastInserId = $db->getInsertId();
                $sql = "SELECT apartments.*, users.email, users.id AS user_id FROM apartments LEFT JOIN users ON apartments.user_id = users.id";
                $rows = $db->query($sql);
                foreach ($rows as $row) {
                    $data = [
                        'bill_id'=> $lastInserId,
                        'user_id'=> $row['user_id'],
                        'amount'=> $amount
                    ];
                    //mail($row['email'], "");
                    $db->insert("incomes", $data);
                }
            }
            $message = "done";
        }else{
            //throw new Exception("teacher not insert");
            $message = "insert failed!!";
        }
    }
    $db->commit();
}catch(e){
    echo $e->getMessage();
    $db->rollback();
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
                            <label for="bill_name" class="form-label">Bill Name</label>
                            <input type="text" class="form-control" id="bill_name"  name="bill_name"  required>
                        </div>
                        <div class="mb-3 mt-3">
                            <p class="form-label">Send All Appartment Owners</p>
                            <small style="color:red;">সব আপার্ট্মেন্ট মালিক কে সেন্ড করার জন্য yes সিলেক্ট করতে হবে।</small>
                            <hr />
                            <input type="radio" id="send_all_no" name="send_all" value="0" checked/>
                            <label for="send_all_no" class="form-label">No</label>
                            <input type="radio" id="send_all_yes" name="send_all" value="1"/>
                            <label for="send_all_yes" class="form-label">Yes</label>
                        </div>
                        <div class="mb-3 mt-3">
                            <span class="form-label">Select Bill Items</span>
                            <div>
                                <table class="table table-striped table-borderedtable-hover">
                                    <tr>
                                        <th></th>
                                        <th>Category</th>
                                        <th>Sub-category</th>
                                        <th>Amount</th>
                                    </tr>
<?php
$sql = "SELECT bill_items.*, categories.cat_name, sub_categories.sub_name
FROM bill_items
LEFT JOIN categories
ON bill_items.cat_id = categories.id
LEFT JOIN sub_categories
ON bill_items.sub_id = sub_categories.id
WHERE bill_items.status = 1";
$bill_items_rows = $db->query($sql);
foreach ($bill_items_rows as $bill_items_row) {
    $ids = 's'.$bill_items_row['id'];
    echo <<<html
    <tr>
        <td><input type="checkbox" id="{$ids}"  name="items_id[]" value="{$bill_items_row['id']}"></td>
        <td><label for="{$ids}" class="form-label">{$bill_items_row['cat_name']}</label></td>
        <td><label for="{$ids}" class="form-label">{$bill_items_row['sub_name']}</label></td>
        <td><label for="{$ids}" class="form-label">{$bill_items_row['amount']}</label></td>
    </tr>
html;
}
?>  
                                </table>
                            <div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit" value="category">Make Bill</button>
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
    
        
    