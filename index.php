<?php
    require_once("connMysql.php");
    session_start();
    if(isset($_GET["logout"]) && $_GET["logout"]==1){
        session_unset();
        header("Location: index.php");
    }
    // if((isset($_SESSION["username"])) && ($_SESSION["username"]!="")){
    //     header("Location: member.php");
    // }
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <head>
        <meta charset="utf-8">
        <title>虛擬美術館</title>
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
                            echo "<li><a href='registerSchool.php'>註冊學校</a></li>";
                            echo "<li><a href='login.php'>登入</a></li>";
                        }
                    ?>

                    <li><a href="#">介紹</a></li>
                    <li><a href="#">關於我們</a></li>
                </ul>
            </nav>   
        </header>
        <main>
            <div class="mainvisual">    <!-- 視覺主圖設定-->
                <img src="img/1.jfif">
            </div>
        </main>
        <article id="profile">  <!-- 第一個articl區塊，命名為profile-->
            <div class="content">  <!-- 設定固定寬度-->
                <h2>目前進度</h2>
                <p>本週+上週的進度:網站首頁的排版完成</br>unity方面:完成了資料庫的連接，並且可以上傳且顯示圖片
                    </br> unity的使用者觀看可以移動。</p>
            </div>
        </article>
        <div class="slider_container" style="display:none">
            <div class="contentPic">
                <img src="img/1.png" alt="pure css3 slider" />
                <span class="info">Image Description 1</span>
            </div>
            <div class="contentPic">
                <img src="img/3.jpg" alt="pure css3 slider" />
                <span class="info">Image Description 2</span>
            </div>
            <div class="contentPic">
                <img src="img/4.jpg" alt="pure css3 slider" />
                <span class="info">Image Description 3</span>
            </div>
        </div>
    </body>
</html>


 


