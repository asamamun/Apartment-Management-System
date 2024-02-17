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
$db = new MysqliDb ();
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
                        <h1 class="mt-4">Dashboard</h1>
                        <hr />
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Bill Name</th>
                                            <th>User</th>
                                            <th>Cteated At</th>
                                            <th>Amount</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Bill Name</th>
                                            <th>User</th>
                                            <th>Cteated At</th>
                                            <th>Amount</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
<?php
$bills = $db->get('bills');
$billArray = null;
foreach ($bills as $bill) {
    $billArray[$bill['id']] = $bill["bill_name"];
}
$users = $db->get('users');
$userArray = null;
foreach ($users as $user) {
    $userArray[$user['id']] = $user["name"];
}
$db->where("status", 0);
$incomes = $db->get('incomes');
foreach ($incomes as $income) {
    echo <<<html
<tr>
    <td>{$billArray[$income['bill_id']]}</td>
    <td>{$userArray[$income['user_id']]}</td>
    <td>{$income['created_at']}</td>
    <td>{$income['amount']}</td>
    <td><a href="users_payment.php?incomes_id={$income['id']}" class="btn btn-danger">Payment</a></td>
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
                </main>
<!-- footer -->
<?php require __DIR__.'/components/footer.php'; ?>
            </div>
        </div>
        <?php require __DIR__.'/components/script.php'; ?>
    </body>
</html>
