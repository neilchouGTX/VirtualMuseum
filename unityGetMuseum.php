<?php
    require_once("connMysql.php");
    if(isset($_GET["school_id"]) && !isset($_GET["exhibition_name"])){
        $sql = "SELECT `exhibition_name` FROM `".$_GET["school_id"]."_exhibition_name`";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            echo $row["exhibition_name"]."_";
        } 
    }
    if(isset($_GET["exhibition_name"]) && isset($_GET["school_id"])){
        $sql = "SELECT `exhibition_museum` FROM `".$_GET["school_id"]."_exhibition_name` WHERE exhibition_name='".$_GET["exhibition_name"]."'";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            echo $row["exhibition_museum"];
        }
    }
?>