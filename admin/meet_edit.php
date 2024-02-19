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
if(isset($_POST['submit'])){
    $idtoupdate = $_POST['id'];
    // $apt_no = $_POST['apt_no'];
    $data = [
            'title'=> $db->escape($_POST['title']),
            'meet_date'=> $db->escape($_POST['date']." ".$_POST['time']),
            'members'=> $db->escape($_POST['member_name']),
            'details'=> $db->escape($_POST['details']),
    ];
    $db->where ('id', $idtoupdate);
    if ($db->update ('meetings', $data))
        $message = "User Updated successfully";
    else{
        $message = "Something went wrong, ".$db->getLastError();
    }
}
if(isset($_GET['id'])){
    $id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
    if($id){
        // $selectQuery = "select id,username,create_at from users where id=$id limit 1";
        // $result = $conn->query($selectQuery);
        // $row = $result->fetch_assoc();
        $db->where ('id', $id);
        $row = $db->getOne('meetings');
// var_dump($row);
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
        <style> 
    .form{
        background-color: mintcream;
        border-radius: 5px;
        box-shadow: -4px 3px 11px 0px rgba(0,0,0,0.75);
    }
    label{
        font-weight: bold;
        font-size: 1.2 em;
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
                                            <form action="" method="post" class="row g-3 form">
                                            <h2 class="h2">Update Meeting</h2><hr>
                                            <div class="mb-3 mt-3">
                            <input type="hidden" class="form-control" id="id"  name="id"  value="<?= $row['id'] ?>">
                                            </div>    
                                            <div class="col-sm-3">
                                                    <label for="title">Title :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="title" name="title" value="<?= $row['title'] ?>" required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="date">Date :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" id="date" name="date" value="<?= $row['meet_date'] ?>" required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="time">Time :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="time" class="form-control" id="time" name="time" value="<?= $row['meet_date'] ?>" required>
                                                </div>
                                                <div class="col-sm-3">
                                                <label for="member_name">Members :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <select name="member_name" id="member_name" class="form-select" required>
                                                <?php
                                                    $member_rows = $db->get("apartment_members");
                                                    foreach($member_rows as $member_row){
                                                        echo "<option value='{$member_row['id']}'>{$member_row['member_name']}</option>";
                                                    }
                                                ?>
                                                </select>
                                                </div>
                                                <div class="col-sm-3">
                                                <label for="details">Details :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" id="details" name="details" value="<?= $row['details'] ?>"></textarea>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-secondary mb-3" name="submit">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </section>
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
    
        
    