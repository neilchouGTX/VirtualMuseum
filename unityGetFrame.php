<?php
    require_once("connMysql.php");
    if(isset($_GET["branch"]) && isset($_GET["art_place"]) && isset($_GET["school_id"])){
        $stmt = $conn->prepare("SELECT `image_id` FROM `".$_GET["school_id"]."_exhibition_hall` WHERE branch=? AND art_place=?");
        $stmt -> bind_param("ss",$_GET["branch"],$_GET["art_place"]);    
        $stmt -> execute();
        $stmt -> bind_result($fetch_image_id);
        $stmt -> fetch();
        $stmt -> close();
        //echo $fetch_image_id."</br>";
        $stmt = $conn->prepare("SELECT `image_path` FROM `".$_GET["school_id"]."_image_attribute` WHERE image_id=?");
        $stmt -> bind_param("s",$fetch_image_id);
        $stmt -> execute();
        $stmt -> bind_result($fetch_image_path);
        $stmt -> fetch();
        $stmt -> close();
        echo $fetch_image_path;  
    }
    
?>