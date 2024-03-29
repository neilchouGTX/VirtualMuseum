<?php
    require_once("connMysql.php");
    if(isset($_GET["museum_name"]) && isset($_GET["art_place"]) && isset($_GET["school_id"])){
        $stmt = $conn->prepare("SELECT `image_id` FROM `".$_GET["school_id"]."_exhibition_hall` WHERE exhibition_name=? AND art_place=?");
        $stmt -> bind_param("ss",$_GET["museum_name"],$_GET["art_place"]);    
        $stmt -> execute();
        $stmt -> bind_result($fetch_image_id);
        $stmt -> fetch();
        $stmt -> close();
        //echo $fetch_image_id."</br>";
        $stmt = $conn->prepare("SELECT `art_name`,`art_author`,`art_description`,`author_class` FROM `".$_GET["school_id"]."_image_data` WHERE image_id=?");
        $stmt -> bind_param("s",$fetch_image_id);
        $stmt -> execute();
        $stmt -> bind_result($fetch_art_name,$fetch_art_author,$fetch_art_description,$fetch_author_class);
        $stmt -> fetch();
        $stmt -> close();
        // echo $fetch_art_name;  
        echo $fetch_art_name."_".$fetch_art_author."_".$fetch_art_description."_".$fetch_author_class;  

    } 
?>