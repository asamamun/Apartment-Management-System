<?php
if(isset($message)){
    ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong><?= $message; ?></strong> 
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    <?php
}
?>