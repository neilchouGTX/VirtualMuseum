<?php
    require_once("connMysql.php");
    session_start();

    if(isset($_SESSION["username"]) && ($_SESSION["username"]!="")){
        header("Location: member.php");
    }
    if(isset($_POST["username"]) && isset($_POST["password"])){
        $stmt = $conn->prepare("SELECT `password`,`permission` FROM `user_account` WHERE username=?");
        $stmt -> bind_param("s",$_POST["username"]);
        $stmt -> execute();
        $stmt -> bind_result($mySqlPWD,$p_permission);
        $stmt -> fetch();
        $stmt -> close();
        if(($_POST["password"] == $mySqlPWD) && ($_POST["password"]!= "")){
            $_SESSION["username"] = $_POST["username"];
            $_SESSION["permission"] = $p_permission;
            header("Location: member.php");
        }
        else{
            $PWDerror = true;
        }
    }
    // if(isset($_COOKIE["counter"])){
    //     $counter = $_COOKIE["counter"];
    //     $counter++;
    //     setcookie("counter",$counter,strtotime("Y-m-d 23:59:59"));
    // }
    // else{
    //     setcookie("counter",1,strtotime("Y-m-d 23:59:59"));
    //     header("Location: index.php");
    // }
    
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <title>虛擬美術館-登入系統</title>
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
                    <!-- <li><a href="registerSchool.php">註冊學校</a></li> -->
                    <li><a href="login.php">登入</a></li>
                    <li><a href="#">介紹</a></li>
                    <li><a href="#">關於我們</a></li>
                </ul>
            </nav>   
        </header>
        <h1>管理員登入系統</h1>
        <!-- <h1>您登入:<?php echo $_COOKIE["counter"]?>次</h1> -->
        <form method="post">
            <div class='loginDiv'>
                <h2>電子郵件:</h2>
                <input name="username" type="text" pattern="^[\w@\.]+$" maxlength="100">
                <h2>密碼:</h2>
                <input name="password" type="password" pattern="[\w]+$" maxlength="50">
                <input class='loginButton' type="submit" name="button" id="button" value="登入系統">
                <?php if(isset($PWDerror) && $PWDerror==true) echo "帳號密碼錯誤" ?>
            </div>
        </form>
    </body>
</html>