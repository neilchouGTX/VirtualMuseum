<?php
    require_once("connMysql.php");
    session_start();
    if(isset($_GET["logout"]) && $_GET["logout"]==1){
        session_unset();
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <head>
        <meta charset="utf-8">
        <title>虛擬美術館-關於我們</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" type="text/css"> 
    </head>
    <body>
        <header>
            <a href="index.php"><div class="logodiv"><img id="logoPic" src="img/newLogo.png"/></div></a>
            <nav>
                <ul class="flex-nav">
                    <li><a href="index.php">首頁</a></li>
                    <?php
                        if((isset($_SESSION["username"])) && ($_SESSION["username"]!="")){
                            echo "<li><a href='member.php'>會員</a></li>";
                            echo "<li><a href='index.php?logout=1'>登出</a></li>";
                        }
                        else{
                            // echo "<li><a href='registerSchool.php'>註冊學校</a></li>";
                            echo "<li><a href='login.php'>登入</a></li>";
                        }
                    ?>

                    <li><a href="introduction.php">介紹</a></li>
                    <li><a href="aboutUs.php">關於我們</a></li>
                </ul>
            </nav>   
        </header>
        <main>
            <div class="mainvisual">    <!-- 視覺主圖設定-->
            </div>
        </main>
        <article id="profile">  <!-- 第一個articl區塊，命名為profile-->
            <div class="content">  <!-- 設定固定寬度-->
                <h2>關於我們</h2>
                <h3>我們是輔仁大學資訊工程學系的學生，這是我們的畢業專題</h3>
            </div>
        </article>
    </body>
</html>