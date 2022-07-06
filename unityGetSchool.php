<?php
    require_once("connMysql.php");
    $sql = "SELECT `name`,`school_id` FROM `city_table`";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        echo $row["name"].",".$row["school_id"]."_";
    }
?>