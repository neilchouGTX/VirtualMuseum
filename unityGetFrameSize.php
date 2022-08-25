<?php
    require_once("connMysql.php");
    if(isset($_GET["museum_name"]) && isset($_GET["art_place"]) && isset($_GET["school_id"])){
        $stmt = $conn->prepare("SELECT `image_id` FROM `".$_GET["school_id"]."_exhibition_hall` WHERE exhibition_name=? AND art_place=?");
        $stmt -> bind_param("ss",$_GET["museum_name"],$_GET["art_place"]);    
        $stmt -> execute();
        $stmt -> bind_result($fetch_image_id);
        $stmt -> fetch();
        $stmt -> close();
        if(isset($fetch_image_id)){
            $stmt = $conn->prepare("SELECT `image_path` FROM `".$_GET["school_id"]."_image_attribute` WHERE image_id=?");
            $stmt -> bind_param("s",$fetch_image_id);
            $stmt -> execute();
            $stmt -> bind_result($fetch_image_path);
            $stmt -> fetch();
            $stmt -> close();
            $ext = pathinfo($fetch_image_path, PATHINFO_EXTENSION);
            if($ext=="jpg")
                $exif = exif_read_data($fetch_image_path);
            if(!empty($exif['Orientation'])) {
                $image = imagecreatefromjpeg($fetch_image_path);
                $image = imagerotate($image, 270, 0);
                imagejpeg($image, $fetch_image_path);
            }
            list($width, $height, $type, $attr) = getimagesize($fetch_image_path);
            echo $width/$height;
        }
    }    
?>