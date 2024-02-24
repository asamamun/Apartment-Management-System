<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
$myfn = new myfn\myfn;
$db = new MysqliDb();
if(isset($_POST['reg'])){
  $bill_id = $_POST['bill_id'];
  $bill_row = $db->where('id', $bill_id)->getOne('bills');
  $data = [
      'user_id'=> $db->escape($_POST['user_id']),
      'bill_id'=> $db->escape($bill_id),
      'amount'=> $bill_row['amount']
  ];
  if($db->insert("incomes",$data)){
      $message = "Done";
      $myfn->msg('msg', $message);
      header("location: ".$_SERVER["HTTP_REFERER"]);
      exit;
  }else{
      $message = "Regitration failed!!";
      $myfn->msg('msg', $message);
      header("location: ".$_SERVER["HTTP_REFERER"]);
      exit;
  }
}
$db->where('id', $_GET['id']);
$row = $db->getOne('users');
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
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
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
                    <img src="<?= $row['image'] != null ? $row['image'] : "stroage/photo.jpg"; ?>" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4><?=$row['name']; ?></h4>
                      <p class="text-secondary mb-1"><?=$row['role'] == 2 ? "Admin" : "User"; ?></p>
                      <p class="text-secondary mb-1"><?=$myfn->only_date($row['created_at']); ?></p>
                      <p class="text-muted font-size-sm"><?=$row['address_one']; ?></p>
                      <a href="logout.php"><button class="btn btn-danger">Logout</button></a>
                      <a href="users_edit.php?id=<?=$row['id'];?>"><button class="btn btn-info">Edit</button></a>
                      <a href="users_img.php?id=<?=$row['id'];?>"><button class="btn btn-info">Photo</button></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mt-3 mb-3 p-4">
                <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Add Bills</i></h6>
                <form action="" method="post" class="form">
                  <input type="hidden" class="" id="user_id"  name="user_id" value="<?=$_GET['id']; ?>" >
                  <div class="input-group">
                      <label for="bill_id" class="btn btn-info">Bill Name:</label>
                      <select class="form-control" id="bill_id"  name="bill_id"  required>
                          <option>Select</option>
<?php
$db->where("status", 1);
$bill_rows = $db->get("bills");
foreach($bill_rows as $bill_row){
    echo "<option value='{$bill_row['id']}'>{$bill_row['bill_name']}</option>";
}
?>                          
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2" name="reg" value="submit" onClick="return comfarm()">Submit</button>
                </form>
              </div>
              <div class="card mt-3">
                <ul class="list-group list-group-flush">
<?php
$bills = $db->get('bills');
$billing = null;
foreach ($bills as $bill) {
    $billing[$bill['id']] = $bill['bill_name'];
}
$incomes = $db->where('user_id', $_GET['id'])->where('status', 0)->get('incomes');
foreach($incomes as $income){
    $style = $income['status'] != 0 ? "green" : "red";
    echo <<<html
<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap" style="background-color:{$style};">
    <h6 class="mb-0">{$billing[$income['bill_id']]}</h6>
    <small>{$myfn->only_date($income['created_at'])}</small>
    <span class="text-secondary">{$income['amount']} TK</span>
    <a href="users_payment.php?incomes_id={$income['id']}" class="btn btn-danger">Payment</a>
</li>
html;
}
?>
                </ul>
              </div>
            </div>
            <div class="col-md-8">
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
                      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Apartments</i></h6>
                        <table class="table">
                            <tr>
                                <th>Apt No</th>
                                <th>Flat Size</th>
                            </tr>
<?php
$appts = $db->where('user_id', $_GET['id'])->get('apartments');
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
                      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Garages</i></h6>
                        <table class="table">
                            <tr>
                                <th>Apt No</th>
                            </tr>
<?php
$gars = $db->where('user_id', $_GET['id'])->get('garages');
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
              </div>



            </div>
          </div>

        </div>
    </div>
    <?=$myfn->msg('msg'); ?>
</body>
</html>