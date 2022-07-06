<?php
    require_once("connMysql.php");
    if(isset($_GET["school_id"])){
        $sql = "SELECT `branch` FROM `".$_GET["school_id"]."_branch`";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            echo $row["branch"]."_";
        } 
    }
?>