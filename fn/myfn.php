<?php
namespace myfn;

use function PHPSTORM_META\type;

class myfn{
    function imageInsert($file){
        $image = $_FILES[$file];
        $image_name = $image['name'];
        $ext_name = end(explode(".", $image_name));
        $image_temp = $image['tmp_name'];
        $image_size = $image['size'];
        $image_path = "stroage/img/".time().rand(1000000, 999999999).".".$ext_name;
        move_uploaded_file($image_temp, $image_path);
        return $image_path;
    }

    public function only_date($date){
        $date1 = strtr($date, '/', '-');
		return date('d/m/Y', strtotime($date1));
	}

    public function getPageName($set){
        return ucwords(implode(" ", explode("_", trim(basename($set), ".php"))));
    }

    public function msg($get, $set = false){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if($set != false){
            $_SESSION[$get] = $set;
        }else{
            if(isset($_SESSION[$get])){
                $session = $_SESSION[$get];
                $result = <<<html
<div class="alert alert-info alert-dismissible fade show" role="alert" style="position: absolute; top:2%; right:2%;">
    <strong><i class="bi bi-envelope"></i> </strong>{$session}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
html;
                //unset($_SESSION[$get]);
                //$_SESSION[$get] = "No Message Found";
                return $result;
            }else{
                return false;
            }
        }
    }


}