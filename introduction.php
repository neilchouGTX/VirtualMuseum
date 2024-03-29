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
        <title>虛擬美術館-介紹</title>
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
                <video width="800" autoplay muted>
                    <source src="img/logoAnimation.mov" type="video/mp4">
                </video>
            </div>
        </main>
        <article id="profile">  <!-- 第一個articl區塊，命名為profile-->
            <div class="content">  <!-- 設定固定寬度-->
                <h2>雲端美術館</h2>
                <h3>我們致力於打造一個虛擬平台，可以讓想展示自己畫作的人有一個虛擬美術館可以擺放，並且讓全世界的人所看見</h3>
            </div>
        </article>
    </body>
</html>