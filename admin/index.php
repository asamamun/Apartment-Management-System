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
                                    <div class="card-body"><h3>Total Income</h3></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        <?php
                                            /* $sql = "SELECT SUM(amount) as amount FROM income_expence WHERE type=1";
                                            //$db->where('type', 1);
                                            $income = $db->query($sql);
                                            echo $income[0]["amount"]." Tk"; */
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card col2 text-white mb-4">
                                    <div class="card-body"><h3>Expence</h3></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        <?php
                                            /* $sql = "SELECT SUM(amount) as amount FROM income_expence WHERE type=0";
                                            //$db->where('type', 1);
                                            $expense = $db->query($sql);
                                            echo $expense[0]["amount"]." Tk"; */
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card col3 text-white mb-4">
                                    <div class="card-body"><h3>Balance</h3></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        <?php
                                            /* echo $income[0]["amount"] - $expense[0]["amount"]." Tk"; */
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card col4 text-white mb-4">
                                    <div class="card-body"><h3>Danger Card</h3></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                        </tr>
                                        <tr>
                                            <td>Garrett Winters</td>
                                            <td>Accountant</td>
                                            <td>Tokyo</td>
                                            <td>63</td>
                                            <td>2011/07/25</td>
                                            <td>$170,750</td>
                                        </tr>
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
<script>
Swal.fire({
  //title: "Custom width, padding, color, background.",
  width: 200,
  position: "top-end",
  background: "#fff url(stroage/checkerboard-gradient.jpg",
  timer: 2000,
  backdrop: `
    rgba(0,0,123,0.4)
    url("stroage/585d0331234507.564a1d239ac5e.gif")
    center center
    no-repeat
  `
});
</script>
    </body>
</html>
