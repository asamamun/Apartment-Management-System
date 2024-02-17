<?php
$pagename = "jhdsfhkasj";
$pagetitle = "";
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
                            <li class="breadcrumb-item active"><h3><?=$pagetitle;?></h3></li>
                        </ol>
                        <div class="row mb-2">
                            <div class="col-md-2"></div>
                            <div class="col-md-8 border border-info rounded p-4">
                                <form action="" method="post">
                                    <div class="mb-3 mt-3">
                                        <label for="cat_id" class="form-label">Category</label>
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
                                        <label for="sub_id" class="form-label">Sub Category</label>
                                        <select class="form-control" id="sub_id" name="sub_id"></select>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="amount" class="form-label">Amount</label>
                                        <input type="text" class="form-control" id="amount"  name="amount"  required>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <!-- <label for="details" class="form-label">Details</label> -->
                                        <textarea class="form-control" id="details"  name="details"></textarea>
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
    </body>
</html>
