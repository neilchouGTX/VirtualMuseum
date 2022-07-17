<?php
    require_once("connMysql.php");
    session_start();
    date_default_timezone_set('Asia/Taipei');
    if((!isset($_SESSION["username"])) || ($_SESSION["username"]=="")){
        header("Location: index.php");
    }
    $stmt = $conn->prepare("SELECT `school_id`,`name`,`permission` FROM `user_account` WHERE username=?");
    $stmt -> bind_param("s",$_SESSION["username"]); 
    $stmt -> execute();
    $stmt -> bind_result($school_id,$mySqlName,$permission);
    $stmt -> fetch();
    $stmt -> close();
    $username = $_SESSION["username"];
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>虛擬美術館-會員</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/mainTheme.css" rel="stylesheet" type="text/css"> 
    </head>
    <body align = center>
        <header>
            <a href="index.php"><div class="logodiv"><img id="logoPic" src="img/newLogo.png"/></div></a>
            <nav>
                <ul class="flex-nav">
                    <li><a href="index.php">首頁</a></li>
                    <li><a href="member.php">會員</a></li>
                    <li><a href="index.php?logout=1">登出</a></li>
                    <li><a href="#">介紹</a></li>
                    <li><a href="#">關於我們</a></li>
                </ul>
            </nav>   
        </header>
        <h1>歡迎<?php echo $mySqlName?>登入</h1>
        <h3>學校代碼:<?php echo $school_id?></h3>
        <h3>權限等級:<?php echo $permission?></h3>
        <?php 
            if($permission==0){
                echo "<input type='button' value='註冊學校' onclick='location.href=\"registerSchool.php\"' style='width:120px;height:40px;font-size:20px;'>";
            }
            else if($permission==1){
                echo "<input type='button' value='上傳圖片' onclick='location.href=\"imageUploader.php\"' style='width:120px;height:40px;font-size:20px;'>";
                echo "<input type='button' value='編輯班級' onclick='location.href=\"branch.php\"' style='width:120px;height:40px;font-size:20px;'>";
                echo "<input type='button' value='新增管理員' onclick='location.href=\"registerAccount.php\"' style='width:120px;height:40px;font-size:20px;'>";
            }
            else{
                echo "<input type='button' value='上傳圖片' onclick='location.href=\"imageUploader.php\"' style='width:120px;height:40px;font-size:20px;'>";
                echo "<input type='button' value='編輯班級' onclick='location.href=\"branch.php\"' style='width:120px;height:40px;font-size:20px;'>";
            }
        ?>
    </body>
</html>