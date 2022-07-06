<?php
    require_once("connMysql.php");
    $sql = "SELECT DISTINCT `exhibition_hall` FROM `museum_hall`";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        echo $row["exhibition_hall"]."_";
    } 
    
    
?>