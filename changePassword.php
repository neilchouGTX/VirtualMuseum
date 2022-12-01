<?php
    require_once("connMysql.php");
    session_start();
    date_default_timezone_set('Asia/Taipei');
    if((!isset($_SESSION["username"])) || ($_SESSION["username"]=="")){
        header("Location: index.php");
    }
    $stmt = $conn->prepare("SELECT `school_id`,`name`,`permission`,`password` FROM `user_account` WHERE username=?");
    $stmt -> bind_param("s",$_SESSION["username"]); 
    $stmt -> execute();
    $stmt -> bind_result($school_id,$mySqlName,$permission,$password);
    $stmt -> fetch();
    $stmt -> close();
    $username = $_SESSION["username"];
    if(isset($_POST["originalPassword"]) && isset($_POST["newPassword"]) && isset($_POST["confirmPassword"])){
        if($_POST["originalPassword"] != $password){
            $changeError = 1;
        }
        else if($_POST["newPassword"] != $_POST["confirmPassword"]){
            $changeError = 2;
        }
        else if($_POST["originalPassword"] == $_POST["newPassword"]){
            $changeError = 3;
        }
        else if(($_POST["originalPassword"] == $password) && ($_POST["newPassword"] == $_POST["confirmPassword"])){
            $sql = "UPDATE `user_account` SET password='".$_POST["newPassword"]."' WHERE username='".$_SESSION["username"]."'";
            $conn->query($sql);
            echo "<h1>將自動登出，請重新登入</h1>";
            header("Refresh:3;url=index.php?logout=1");
            exit();
        }
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>虛擬美術館-會員</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/mainTheme.css" rel="stylesheet" type="text/css">
        <link href="css/login.css" rel="stylesheet" type="text/css"> 
    </head>
    <body align = center>
        <header>
            <a href="index.php"><div class="logodiv"><img id="logoPic" src="img/newLogo.png"/></div></a>
            <nav>
                <ul class="flex-nav">
                    <li><a href="index.php">首頁</a></li>
                    <li><a href="member.php">會員</a></li>
                    <li><a href="index.php?logout=1">登出</a></li>
                    <li><a href="introduction.php">介紹</a></li>
                    <li><a href="aboutUs.php">關於我們</a></li>
                </ul>
            </nav>   
        </header>
        <h1>歡迎<?php echo $mySqlName?>登入</h1>
        <h1>更改密碼</h1>
        <form method="post">
            <div class='loginDiv'>
                <h2>原密碼:</h2>
                <input name="originalPassword" type="password" pattern="[\w]+$" maxlength="50" required="required">
                <h2>新密碼:</h2>
                <input name="newPassword" type="password" pattern="[\w]+$" maxlength="50" required="required">
                <h2>再次輸入新密碼:</h2>
                <input name="confirmPassword" type="password" pattern="[\w]+$" maxlength="50" required="required">
                <input class='loginButton' type="submit" name="button" id="button" value="變更密碼">
                <?php if(isset($changeError) && $changeError==1) echo "<p>原密碼錯誤</p>" ?>
                <?php if(isset($changeError) && $changeError==2) echo "<p>新密碼兩次輸入不同</p>" ?>
                <?php if(isset($changeError) && $changeError==3) echo "<p>舊密碼與新密碼相同" ?>
            </div>
        </form>

    </body>
</html>