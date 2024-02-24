<nav class="sb-topnav navbar navbar-expand " style="background-color: 	#91caea;">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.html"><?= settings()['companyname']?></a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form action="mem_search.php" class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" method="GET">
        <div class="input-group">
            <input class="form-control" type="text" name="keywords" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="<?=$_SESSION['photo']; ?>" width="30" height="30" style="border-radius: 50%;"/></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item text-success" href="users_profile.php?id=<?=$_SESSION["userid"]; ?>"><strong><?= $_SESSION['username'] ?></strong></a></li>
                <li><a class="dropdown-item" href="info.php">Plot Info</a></li>
                <li><a class="dropdown-item" href="plot_photo.php">Plot Picture</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="<?=settings()['adminpage']?>logout.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
        