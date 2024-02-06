<?php
namespace myfn;
class myfn{
    function imageInsert($file){
        $image = $_FILES[$file];
        $image_name = $image['name'];
        $image_temp = $image['tmp_name'];
        $image_size = $image['size'];
        $image_path = "stroage/img/".time().rand(1000000, 999999999).$image_name;
        move_uploaded_file($image_temp, $image_path);
        return $image_path;
    }
}