<?php
require __DIR__ . '/vendor/autoload.php';
$page = "Registration";
if(isset($_POST['reg'])){
$db = new MysqliDb();
if($_POST['pass1'] == $_POST['pass2']){
    $data = [
        'name'=> $db->escape($_POST['firstname'])." ". $db->escape($_POST['lastname']),
        'email'=> $db->escape($_POST['email']),
        'password' => password_hash($_POST['pass1'],PASSWORD_DEFAULT),
        'role' => "1"
    ];
    if($db->insert("users",$data)){
        header("location:login.php");
    }
    else{
        $message = "Regitration failed!!";
    }
}

}
?>

<?php require __DIR__ . '/components/header.php';?>

</head>
<body>
<div class="container">
<?php require __DIR__ . '/components/menubar.php';?>

<h1>registration page</h1>
<?php require __DIR__ . '/components/dismissalert.php';?>
<!--  -->
<form class="row g-3 needs-validation" novalidate method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
  <div class="col-md-4 form-floating">
  <input type="text" class="form-control" name="firstname" id="firstname" value="" required placeholder="first name">
<label for="firstname" class="form-label">First name</label>
    
    <div class="valid-feedback">
      Looks good!
    </div>
  </div>
  <div class="col-md-4 form-floating">
  <input type="text" class="form-control" name="lastname" id="lastname" value="" required placeholder="last name">
    <label for="lastname" class="form-label">Last name</label>
    
    <div class="valid-feedback">
      Looks good!
    </div>
  </div>
  <div class="col-md-4 form-floating">
    <input type="text" class="form-control" id="username" name="username" aria-describedby="inputGroupPrepend" required placeholder="user name">
      <label for="username" class="form-label">Username</label>
      <div class="invalid-feedback">
        Please choose a username.
      </div>

    
  </div>
  <div class="col-md-6 form-floating">
    
    <input type="email" class="form-control" id="email" name="email" required placeholder="yourname@domain.com">
    <label for="email" class="form-label">Email</label>
    <div class="invalid-feedback">
      Please provide a valid email.
    </div>
    <div class="valid-feedback">
      Email Valid!!
    </div>
  </div>
  <div class="col-md-3 form-floating">    
    <input type="password" minlength="5" class="form-control" id="pass1" name="pass1" required placeholder="password">
    <label for="pass1" class="form-label">Password</label>
    <div class="invalid-feedback">
      Please provide a valid password.
    </div>
  </div>
  <div class="col-md-3 form-floating">    
    <input type="password" minlength="5" class="form-control" id="pass2" name="pass2" required placeholder="retype password">
    <label for="pass2" class="form-label">Retype Password</label>
    <div class="invalid-feedback">
      Please provide a valid length password.
    </div>
  </div>
  <div class="col-12">
    <div class="form-check">
      
      <label class="form-check-label" for="invalidCheck">
        Agree to terms and conditions
      </label>
      <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
      <div class="invalid-feedback">
        You must agree before submitting.
      </div>
    </div>
  </div>
  <div class="col-12">
    <button class="btn btn-primary" type="submit" name="reg" value="Sign Up">Register</button>
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
    
