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
            <div class="mainvisual" style="height : 500px ; width:auto; overflow : hidden">    <!-- 視覺主圖設定-->
                <img id="autoChangeMainVisual" src="img/mainVisual2.png">
            </div>
        </main>
        <script>
            var imageSources = ["img/mainVisual2.png", "img/mimi1.png", "img/huaShengDun.png", "img/tawado.png"]
            var index = 0;
            setInterval (function(){
            if (index === imageSources.length) {
                index = 0;
            }
            document.getElementById("autoChangeMainVisual").src = imageSources[index];
            index++;
            } , 2000);
        </script>
        <article id="profile">  <!-- 第一個articl區塊，命名為profile-->
            <div class="content">  <!-- 設定固定寬度-->
                <h2>參觀列表</h2>
                <?php
                    $sql = "SELECT `school_id`,`city`,`name` FROM city_table";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()){
                        echo "<p>";
                        echo "<a href=\"webgl/index.html?school_id=".$row["school_id"]."\">";
                        echo $row["city"].$row["name"]."</a>";
                        echo "</a>";
                        echo "</p>";
                    } 
                ?>
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