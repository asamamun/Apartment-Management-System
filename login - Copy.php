<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/vendor/autoload.php';
$page = "Login";
if(isset($_POST['login'])){
    $db = new MysqliDb();
    $db->where("email", $_POST['email']);
    $row = $db->getOne ("users");
    if($row){
        if(password_verify($_POST['pass1'],$row['password'])){
            $_SESSION['loggedin'] = true;
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['name'];
            $_SESSION['role'] = $row['role'];
            if($row['role'] == "2"){
                header('Location:admin/');
            }
            elseif($row['role'] == "1"){
                header('Location:index.php');
            }
            else{
                header('Location:index.php');  
            }

        }
        else{
            $message = "Passwords do not match";
        }
    }
    else{
        $message = "Invalid Account";
    }

}
?>

<?php require __DIR__ . '/components/header.php';?>

</head>
<body>
  <h1><?= config('test.course') ?></h1>
<div class="container">
<?php require __DIR__ . '/components/menubar.php';?>
<h1>Login page</h1>
<?php require __DIR__ . '/components/dismissalert.php';?>
<!--  -->
<form class="row g-3 needs-validation" novalidate method="post" action="<?= $_SERVER['PHP_SELF'] ?>">

  <div class="col-md-12 form-floating">
    
    <input type="email" class="form-control" id="email" name="email" required placeholder="yourname@domain.com">
    <label for="email" class="form-label">Email</label>
    <div class="invalid-feedback">
      Please provide a valid email.
    </div>
    <div class="valid-feedback">
      Email Valid!!
    </div>
  </div>
  <div class="col-md-12 form-floating">    
    <input type="password" minlength="5" class="form-control" id="pass1" name="pass1" required placeholder="password">
    <label for="pass1" class="form-label">Password</label>
    <div class="invalid-feedback">
      Please provide a valid password.
    </div>
  </div>
  <div class="col-12">
    <button class="btn btn-primary" type="submit" name="login" value="Sign In">Login </button>
  </div>
</form>
<!--  -->
<?php
// echo testfunc();
?>
</div>
<script>

</script>
<?php require __DIR__ . '/components/footer.php';?>
    
