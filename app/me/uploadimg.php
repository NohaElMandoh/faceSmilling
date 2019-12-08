<?php

if (isset($_FILES["uploaded_file"]["name"])){

    $name=$_FILES["uploaded_file"]["name"];
    $tmp_name=$_FILES["uploaded_file"]["temp_name"];
    $error=$_FILES["uploaded_file"]["error"];

    if (!empty($name)){


        $location='';
        if (!is_dir($location))
            mkdir($location);
        if (move_uploaded_file($tmp_name,$location.$name))
            echo 'uploaded';

    }else echo 'please choose afile';

}
?>
