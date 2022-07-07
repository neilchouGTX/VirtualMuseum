<?php
    require_once("connMysql.php");
    session_start();
    if(isset($_GET["logout"]) && $_GET["logout"]==1){
        session_unset();
        header("Location: index.php");
    }
    if((isset($_SESSION["username"])) && ($_SESSION["username"]!="")){
        header("Location: member.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/index.css">
        <header>
            <h1>
              虛擬美術館圖片上傳系統  
            </h1>
        </header>
        <meta charset="utf-8">    
        <title>註冊系統</title>
    </head>
    <body align = center>
        <input type="button" value="註冊學校" onclick="location.href='registerSchool.php'" style="width:120px;height:40px;font-size:20px;">
        <input type="button" value="登入" onclick="location.href='login.php'" style="width:120px;height:40px;font-size:20px;">
    </body>
</html>