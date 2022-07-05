<?php
    require_once("connMysql.php");
    session_start();

    if(isset($_SESSION["username"]) && ($_SESSION["username"]!="")){
        header("Location: member.php");
    }
    if(isset($_POST["username"]) && isset($_POST["password"])){
        $stmt = $conn->prepare("SELECT `password` FROM `user_account` WHERE username=?");
        $stmt -> bind_param("s",$_POST["username"]);
        $stmt -> execute();
        $stmt -> bind_result($mySqlPWD);
        $stmt -> fetch();
        $stmt -> close();
        if(($_POST["password"] == $mySqlPWD) && ($_POST["password"]!= "")){
            $_SESSION["username"] = $_POST["username"];
            header("Location: member.php");
        }
        else{
            $PWDerror = true;
        }
    }
    if(isset($_COOKIE["counter"])){
        $counter = $_COOKIE["counter"];
        $counter++;
        setcookie("counter",$counter,strtotime("Y-m-d 23:59:59"));
    }
    else{
        setcookie("counter",1,strtotime("Y-m-d 23:59:59"));
        header("Location: index.php");
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">    
        <title>管理員登入系統</title>
    </head>
    <body align = center>
        <h1>管理員登入系統</h1>
        <h1>您登入:<?php echo $_COOKIE["counter"]?>次</h1>
        <form method="post">
            <p>
                帳號:
                </br>
                <input name="username" type="text">
                </br>
                密碼:
                </br>
                <input name="password" type="password">
                <br>
                <input type="submit" name="button" id="button" value="登入系統">
                <br>
                <?php if(isset($PWDerror) && $PWDerror==true) echo "帳號密碼錯誤" ?>
            </p>
        </form>
    </body>
</html>