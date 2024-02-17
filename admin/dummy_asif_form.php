<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
$myfn = new myfn\myfn();
?>
<?php require __DIR__.'/components/header.php'; ?>
<link href="<?= settings()['adminpage'] ?>assets/css/asif_form.css" rel="stylesheet" />

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
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                            <!-- user -->
                            <section class="p-3 p-md-3 p-xl-5">
                                <div class="container">
                                    <div class="col-sm-7">
                                    <div class="card border-0 shadow-sm rounded-4">
                                        <div class="card-body">
                                        <div class="row">
                                            <form action="" method="post" class="row g-3 form">
                                                <div class="col-sm-3">
                                                    <label for="username">User Name :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="username" name="username" required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="phone">Phone :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="phone" class="form-control" id="phone" name="phone" required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="email">Email :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="email" class="form-control" id="email" name="email" required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="password">Password :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="password" class="form-control" id="password" name="password" required>
                                                </div>
                                                <div class="col-sm-3">
                                                <label for="role">Type :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                <select name="role" id="role" class="form-select" required>
                                                    <option disabled selected>Open this menu</option>
                                                    <option value="1">User</option>
                                                    <option value="2">Admin</option>
                                                </select>
                                                </div>
                                                <div class="col-sm-3">
                                                <label for="address">Address :</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" id="address" name="address"></textarea>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-secondary mb-3" name="submit" value="category">Create</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </section>
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
