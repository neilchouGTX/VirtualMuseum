<?php
    require_once("connMysql.php");
    session_start();
    date_default_timezone_set('Asia/Taipei');
    if((!isset($_SESSION["username"])) || ($_SESSION["username"]=="")){
        header("Location: index.php");
    }
    $stmt = $conn->prepare("SELECT `school_id`,`name` FROM `user_account` WHERE username=?");
    $stmt -> bind_param("s",$_SESSION["username"]); 
    $stmt -> execute();
    $stmt -> bind_result($school_id,$mySqlName);
    $stmt -> fetch();
    $stmt -> close();
    $username = $_SESSION["username"];
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">    
        <title>管理員系統</title>
    </head>
    <body align = center>
        <h1>歡迎<?php echo $mySqlName?>登入</h1>
        <input type="button" value="上傳圖片" onclick="location.href='imageUploader.php'" style="width:120px;height:40px;font-size:20px;">
        <input type="button" value="編輯班級" onclick="location.href='branch.php'" style="width:120px;height:40px;font-size:20px;">
        <input type="button" value="登出" onclick="location.href='index.php?logout=1'" style="width:120px;height:40px;font-size:20px;">
    </body>
</html>