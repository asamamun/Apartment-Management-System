<?php
$pagename = "jhdsfhkasj";
$pagetitle = "";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';

use App\auth\Admin;
$myfn = new myfn\myfn();
if (!Admin::Check()) {
    header('HTTP/1.1 503 Service Unavailable');
    exit;
}
$db = new MysqliDb();
if (isset($_POST['submit'])) {
    $idtoupdate = $_POST['id'];
    $data = [
        'email' => $_POST['email'],
        'google_map' => $_POST['google_map']
    ];
    $db->where('id', $idtoupdate);
    if ($db->update('plot_info', $data))
        $message = "User Updated successfully";
    else {
        $message = "Something went wrong, " . $db->getLastError();
    }
}
$db->where('id', 1);
$row = $db->getOne('plot_info');
?>

<?php require __DIR__ . '/components/header.php'; ?>
</head>

<body class="sb-nav-fixed">
    <?php require __DIR__ . '/components/navbar.php'; ?>
    <div id="layoutSidenav">
        <?php require __DIR__ . '/components/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <!-- changed content -->
                <div class="container p-4">
                    <h1 class="mt-4"><?=$myfn->getPageName(__FILE__);?></h1>
                    <hr />
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"><h3><?=$pagetitle;?></h3></li>
                    </ol>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="mb-3 mt-3">
                                    <input type="hidden" class="form-control" id="id" name="id" value="1">
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control" id="country" name="country" value="Bangladesh">
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="divisions" class="form-label">Divisions</label>
                                    <select class="form-control" id="divisions" name="division" onChange="getApi('divisions', 'districts')">
                                        <option>select</option>
                                        <?php
                                        $div_rows = $db->get("divisions");
                                        foreach ($div_rows as $div_row) {
                                            echo "<option value='{$div_row['id']}'>{$div_row['bn_name']}</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="districts" class="form-label">District</label>
                                    <select class="form-control" id="districts" name="district" onChange="getApi('districts', 'upazillas')"></select>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="upazillas" class="form-label">Upazila</label>
                                    <select class="form-control" id="upazillas" name="upazilla" onChange="getApi('upazillas', 'unions')"></select>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="unions" class="form-label">Union</label>
                                    <select class="form-control" id="unions" name="union"></select>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="address" class="form-label">Address:</label>
                                    <textarea class="form-control" id="address" name="address"><?= $row['address']??"" ?></textarea>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="help_line" class="form-label">Help line</label>
                                    <input type="text" class="form-control" id="help_line" name="help_line" value="<?= $row['help_line']?? "" ?>">
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= $row['email']?? "" ?>">
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="google_map" class="form-label">Google Map</label>
                                    <input type="text" class="form-control" id="google_map" name="google_map" value="<?= $row['google_map']?? "" ?>">
                                </div>
                                <button type="submit" class="btn btn-primary" name="submit" value="update">Submit</button>
                            </form>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                <?=$myfn->msg('msg'); ?>
                <!-- changed content  ends-->
            </main>
            <!-- footer -->
            <?php require __DIR__ . '/components/footer.php'; ?>
        </div>
    </div>
    <script src="<?= settings()['adminpage'] ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= settings()['adminpage'] ?>assets/js/scripts.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->
    <!-- <script src="<?= settings()['adminpage'] ?>assets/demo/chart-area-demo.js"></script> -->
    <!-- <script src="<?= settings()['adminpage'] ?>assets/demo/chart-bar-demo.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script> -->
    <!-- <script src="<?= settings()['adminpage'] ?>assets/js/datatables-simple-demo.js"></script> -->
    <script>
        function getApi(get, set) {
            var str = document.getElementById(get).value;
            let url = "info_api.php?id=" + str + "&set=" + set + "&get=" + get;
            fetch(url)
                .then(res => res.text())
                .then(d => {
                    document.getElementById(set).innerHTML = d;
                })
        }
    </script>
</body>

</html>