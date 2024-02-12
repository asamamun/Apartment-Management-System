<?php
require __DIR__ . '/vendor/autoload.php';
$page = "Registration";
$db = new MysqliDb ();
if(isset($_POST['reg'])){
  if($_POST['password'] == $_POST['repassword']){
    $data = [
        'name'=> $db->escape($_POST['username']),
        'phone'=> $db->escape($_POST['phone']),
        'email'=> $db->escape($_POST['email']),
        'address_one'=> $db->escape($_POST['address']),
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
    ];
    if($db->insert("users",$data)){
        header("location: index.php");
    }
    else{
        $message = "Regitration failed!!";
    }
  }else{
    $message = "password not match!!";
  }
}
?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Registration or Sign Up form </title> 
    <link rel="stylesheet" href="<?= settings()['homepage'] ?>assets/registration.css">
   </head>
<body>
  <div class="wrapper">
    <h2>Registration</h2>
    <form action="" method="post">
      <div class="input-box">
        <input type="text" name="username" placeholder="Enter your name" required>
      </div>
      <div class="input-box">
        <input type="phone" name="phone" placeholder="Enter your phone/mobile number." required>
      </div>
      <div class="input-box">
        <input type="text" name="email" placeholder="Enter your email." required>
      </div>
      <div class="input-box">
        <textarea name="address" placeholder="Address" required></textarea>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Create password" required>
      </div>
      <div class="input-box">
        <input type="password" name="repassword" placeholder="Confirm password" required>
      </div>
      <div class="policy">
        <input type="checkbox">
        <h3>I accept all terms & condition</h3>
      </div>
      <div class="input-box button">
        <input type="Submit" value="Register Now" name="reg">
      </div>
      <div class="text">
        <h3>Already have an account? <a href="login.php">Login now</a></h3>
      </div>
    </form>
  </div>
</body>
</html>

