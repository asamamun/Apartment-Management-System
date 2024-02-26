<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
$myfn = new myfn\myfn;
use App\auth\Admin;
if(!Admin::Check()){
    //header('HTTP/1.1 503 Service Unavailable');
    header('location: https://coders24x7.com/apartment/');
    exit;
}
$db = new MysqliDb ();
?>
<?php require __DIR__.'/components/header.php'; ?>


<style>
    .col1{
        /* background-color: rgb(167,216,222); */
        /* background-color: #a296c5; */
        /* background-color: 	#fdd5df; */
        background-color: #4c3a6e;
     
    }
    .col2{
        /* background-color: rgb(167,216,222); */
        /* background-color: #a296c5; */
        /* background-color: 	#fdd5df; */
        background-color: 	#42558d;
    
    }
    .col3{
        /* background-color: rgb(167,216,222); */
        /* background-color: #a296c5; */
        /* background-color: 	#fdd5df; */
        background-color: 			#97da70;
    
    }
    .col4{
        /* background-color: rgb(167,216,222); */
        /* background-color: #a296c5; */
        /* background-color: 	#fdd5df; */
        background-color: 	#bd85c4;
    
    }
</style>
    </head>
    <body class="sb-nav-fixed">
    <?php require __DIR__.'/components/navbar.php'; ?>
        <div id="layoutSidenav">
        <?php require __DIR__.'/components/sidebar.php'; ?>
            <div id="layoutSidenav_content">
                <main>
                    <!-- changed content -->
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Welcome</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><h3>Housing Society</h3></li>
                        </ol>
                        <!-- <div class="row"> -->
                        <div class="row justify-content-center">
                            <div class="col-xl-3 col-md-6">
                                <div class="card col1 text-white  mb-4">
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <div class="small text-white"><i class="bi bi-currency-dollar"></i> Incomes</div>
                                        <?php
                                            $sql = "SELECT SUM(amount) as amount FROM incomes WHERE status = 1";
                                            $income = $db->query($sql);
                                            $total_income = $income[0]["amount"];
                                            echo $total_income." Tk";
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card col2 text-white mb-4">
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white"><i class="bi bi-currency-dollar"></i> Expences</div>
                                        <?php
                                            $sql_01 = "SELECT SUM(amount) as amount FROM expences WHERE 1";
                                            $expense = $db->query($sql_01);
                                            $sql_02 = "SELECT SUM(amount) as amount FROM emp_salary WHERE 1";
                                            $salary = $db->query($sql_02);
                                            $total_expense =  $expense[0]["amount"]+$salary[0]["amount"];
                                            echo $total_expense." Tk";
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card col3 text-white mb-4">
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white"><i class="bi bi-currency-dollar"></i> Balance</div>
                                        <?php
                                            echo ($total_income-$total_expense)." Tk";
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6" onclick="window.location.href='income_due.php'">
                                <div class="card col4 text-white mb-4">
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <div class="small text-white"><i class="bi bi-currency-dollar"></i> Due Bills</div>
                                        <?php
                                            $sql = "SELECT SUM(amount) as amount FROM incomes WHERE status = 0";
                                            $income = $db->query($sql);
                                            $total_due = $income[0]["amount"];
                                            echo $total_due." Tk";
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Area Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Bar Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Complain
                                    </div>
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>SN</th>
                                                <th>Title</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
$i=0;
$comRows = $db->get('complain');
foreach($comRows as $comRow){
    $i++;
    echo <<<html
    <tr class="">
      <td>{$i}</td>
      <td>{$comRow['title']}</td>
      <td>{$comRow['created_at']}</td>
      <td><a class="btn btn-info" href="complain_edit.php?id={$comRow['id']}">Open</a></td>
    </tr>
html;
}
?>

                                        </tbody>                                  
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        All Due Bills
                                    </div>
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>SN</th>
                                                <th>Bill</th>
                                                <th>User Name</th>
                                                <th>Created At</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
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
$i=0;
foreach ($incomes as $income) {
    $i++;
    echo <<<html
<tr>
    <td>{$i}</td>
    <td>{$billArray[$income['bill_id']]}</td>
    <td>{$userArray[$income['user_id']]}</td>
    <td>{$income['created_at']}</td>
    <td>{$income['amount']} TK</td>
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
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Today Visitor
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
$vst_rows = $db->get('apartments');
$vst_arr = array();
foreach($vst_rows as $vst_value){
    $vst_arr[$vst_value['id']] = $vst_value['apt_no'];
}
$sql = "SELECT * FROM `visitors` WHERE entry_time >= curdate()";
$rows = $db->query($sql);
foreach($rows as $row){
    if($row['exit_time'] == null){
        $ifnull="style='background-color:#ff6060'";
        $extButton = "<td><a class='btn btn-sm btn-success' href='visitor_func.php?id={$row['id']}&func=exit_func'>Exit</a></td>";
    }else{
        $ifnull="style='background-color:#52bf91'";
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
                    <!-- changed content  ends-->
                    <?=$myfn->msg('msg'); ?>
                </main>
<!-- footer -->
<?php require __DIR__.'/components/footer.php'; ?>
            </div>
        </div>
        <?php require __DIR__.'/components/script.php'; ?>
<script>
Swal.fire({
  //title: "Custom width, padding, color, background.",
  width: 200,
  position: "top-end",
  background: "#fff url(stroage/LightGraySolid.jpg)",
  timer: 3000,
  backdrop: `
    rgba(0,0,123,0.4)
    url("stroage/Hacker_new.gif")
    center center
    no-repeat
  `
});
</script>
    </body>
</html>
