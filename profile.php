<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/vendor/autoload.php';
$myfn = new myfn\myfn;
$db = new MysqliDb();
$db->where('id', $_SESSION['role']);
$row = $db->getOne('users');

if(isset($_POST['submit']) && $_POST['submit'] == 'cominsert'){
  $data = [
      'user_id'=> $_SESSION['userid'],
      'title'=> $db->escape($_POST['title']),
      'details'=> $db->escape($_POST['details']),
  ];
  if($db->insert("complain", $data)){
    $message = "insert success!!";
    $myfn->msg('msg', $message);
    header("location: profile.php");
    exit;
  }else{
      $message = "insert error!!";
      $myfn->msg('msg', $message);
      header("location: profile.php");
      exit;
  }
}
$rows = $db->get('complain');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= settings()['homepage'] ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= settings()['homepage'] ?>assets/profile.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    label{
        font-weight: bold;
        font-size: 1.1em;
    }
    </style>
</head>
<body>
<div class="container">
    <div class="main-body">
    
          <!-- Breadcrumb -->
          <nav class="navbar navbar-expand-lg bg-body-tertiary mb-3">
          <div class="container-fluid">
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                
              </ul>
              <form class="d-flex" role="search">
                <button class="btn btn-sm btn-outline-danger" type="submit">Logout</button>
              </form>
            </div>
          </div>
        </nav>
          <!-- /Breadcrumb -->
    
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="<?="admin/".$row['image']; ?>" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4><?=$row['name']; ?></h4>
                      <p class="text-secondary mb-1"><?=$row['role'] == 2 ? "Admin" : "User"; ?></p>
                      <p class="text-secondary mb-1"><?=$myfn->only_date($row['created_at']); ?></p>
                      <p class="text-muted font-size-sm"><?=$row['address_one']; ?></p>
                      <a href="logout.php"><button class="btn btn-danger">Logout</button></a>
                      <button class="btn btn-info" id="complainShow">Complain</button>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="card mt-3">
                <ul class="list-group list-group-flush">
<?php
$bills = $db->get('bills');
$billing = null;
foreach ($bills as $bill) {
    $billing[$bill['id']] = $bill['bill_name'];
}
$incomes = $db->where('user_id', $_SESSION['userid'])->where('status', 0)->get('incomes');
foreach($incomes as $income){
    $style = $income['status'] != 0 ? "green" : "#ff6060";
    echo <<<html
<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap" style="background-color:{$style};">
    <h6 class="mb-0">{$billing[$income['bill_id']]}</h6>
    <small>{$myfn->only_date($income['created_at'])}</small>
    <span class="text-dark">{$income['amount']}</span>
</li>
html;
}
?>
                </ul>
              </div>
              <!-- complain decision -->
              <div class="card mt-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h5 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Complain Decision</i></h5>
                        <table class="table">
                            <tr>
                                <th>Title</th>
                                <th>Decision</th>
                            </tr>
<?php
$crows = $db->get('complain');
foreach($crows as $crow){
    echo <<<html
<tr>
    <td>{$crow['title']}</td>
    <td>{$crow['decision']}</td>
</tr>
html;
}
?> 
                        </table>         
                    </div>
                  </div>
                </div>
              <!-- complain decision end -->
            </div>

            <div class="col-md-8">
              
            <div class="col-sm mb-3" id="complainbox">
                <div class="card h-100">
                  <div class="card-body">
                    <h4 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Complain</i></h4>
                    <form action="" method="post" class="row g-3 form">                                                <div class="col-sm-3">
                        <label for="title">Title :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="col-sm-3">
                        <label for="details">Details :</label>
                        </div>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="details" name="details"></textarea>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary mb-3" name="submit" value="cominsert">Submit</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
             
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?=$row['name']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?=$row['email']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?=$row['phone']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Mobile</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?=$row['mobile']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?=$row['address_one']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address Two</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?=$row['address_two']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Role</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?=$row['role'] == 2 ? "Admin" : "User"; ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row gutters-sm">
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h5 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Apartments</i></h5>
                        <table class="table">
                            <tr>
                                <th>Apt No</th>
                                <th>Flat Size</th>
                            </tr>
<?php
$appts = $db->where('user_id', $_SESSION['userid'])->get('apartments');
foreach($appts as $appt){
    echo <<<html
<tr>
    <td>{$appt['apt_no']}</td>
    <td>{$appt['flat_size']}</td>
</tr>
html;
}
?> 
                        </table>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h5 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Garages</i></h5>
                        <table class="table">
                            <tr>
                                <th>Apt No</th>
                            </tr>
<?php
$gars = $db->where('user_id', $_SESSION['userid'])->get('garages');
foreach($gars as $gar){
    echo <<<html
<tr>
    <td>{$gar['gar_no']}</td>
</tr>
html;
}
?> 
                        </table>         
                    </div>
                  </div>
                </div>
                <!-- complain -->   
                  </div>




                      



                  </div>
                </div>
          </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
$(document).ready(function(){
  $('#complainbox').hide();
  $('#complainShow').click(function(){
    $('#complainbox').toggle();
  });
});
</script>
<?= $myfn->msg('msg'); ?>
</body>
</html>