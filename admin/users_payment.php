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
$myfn = new myfn\myfn();
$db = new MysqliDb();

if(isset($_POST["payment"])){
    $data = [
        'type' => $_POST['type'],
        'info' => $_POST['info'] ?? null,
        'payment_at' => date('Y-m-d h:i:m'),
        'pay_id' => 'txt'.rand(1000, 9999).time(),
        'smt_id' => $_SESSION['userid'],
        'status' => 1
    ];
    //mail();
    $incomes = $db->where('id', $_GET['incomes_id'])->update('incomes', $data);
    $myfn->msg('msg', 'payment done');
    header("location: users_memo.php?incomes_id={$_GET['incomes_id']}}");
    exit;
}

$billing = null;
$bills = $db->get('bills');
foreach ($bills as $bill) {
    $billing[$bill['id']] = $bill['bill_name'];
}

$username = null;
$users = $db->get('users');
foreach ($users as $user) {
    $username[$user['id']] = [$user['name'], $user['image']];
}

$incomes = $db->where('id', $_GET['incomes_id'])->where('status', 0)->getOne('incomes');
if(!$incomes){
    header("location: users_memo.php?incomes_id={$_GET['incomes_id']}");
    exit;
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
                        <h1 class="mt-4"><img src="<?=$username[$incomes['user_id']][1]; ?>" class="img-thumbnail" width="50"/> <?=$username[$incomes['user_id']][0]; ?></h1>
                        <hr />
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><h3><?=$billing[$incomes['bill_id']]; ?></h3></li>
                        </ol>
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <fieldset>
                                    <!-- <legend>Personalia:</legend> -->
                                    <form action="?incomes_id=<?=$incomes['id']; ?>" method="post">
                                        <div class="mb-3 mt-3">
                                            <label for="phone" class="form-label">Amount:</label>
                                            <input type="text" class="form-control" id="phone"  name="amount" value="<?=$incomes['amount']; ?>" required readonly>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label for="type" class="form-label">Type:</label>
                                            <select name="type" id="role" class="form-control" required>
                                                <option value="1">Cash</option>
                                                <option value="2">Bank Payment</option>
                                                <option value="3">Chack</option>
                                                <option value="4">Mobile Banking</option>
                                                <option value="5">Other</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <textarea class="form-control" name="info" id="textarea"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="payment" value="submit">Submit</button>
                                        <a class="btn btn-primary" href="bill.php?id=<?=$incomes['bill_id']; ?>">Bill View</a>
                                    </form>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <img src="stroage/VV-Society-Logo.avif" width="100%"/>
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
