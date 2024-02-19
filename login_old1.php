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
        if(password_verify($_POST['password'],$row['password'])){
            $_SESSION['loggedin'] = true;
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['name'];
            $_SESSION['photo'] = $row['image'];
            $_SESSION['role'] = $row['role'];
            if($row['role'] == "2"){
                header('Location:admin/');
            }elseif($row['role'] == "1"){
                header('Location:profile.php');
            }else{
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
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
      <div class="input-box">
        <input type="email" name="email" placeholder="Enter your name" required>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Enter your phone/mobile number." required>
      </div>
      <div class="input-box button">
        <input type="Submit" value="login" name="login">
      </div>
      <div class="text">
        <h3>Already have an account? <a href="login.php">Login now</a></h3>
      </div>
    </form>
  </div>
</body>
</html>

