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
<html lang="zh-Hant-TW">
    <head>
        <header>
        <meta charset="utf-8">   <!-- utf-8編碼，中文不會產生亂碼 -->
        <title>虛擬美術館</title>  <!-- 網頁標題 -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- 指定螢幕寬度為裝置寬度，畫面載入初始縮放比例100%-->
        <meta name="description" content="網頁設計入門筆記。">  <!-- 提供搜尋引擎關於網頁頁面內的重要資訊-->
        <link href="css/style.css" rel="stylesheet" type="text/css">
        </header>
        <meta charset="utf-8">    
    </head>



<body>
                <header>
                    <img src="img/log.png" style="display:block; margin:auto;" />

                    <nav>
                        <ul class="flex-nav">
                            <li><a href="#">首頁</a></li>
                            <li><a href="registerSchool.php">註冊學校</a></li>
                            <li><a href="login.php">登入</a></li>
                            <li><a href="#">介紹</a></li>
                            <li><a href="#">關於我們</a></li>
                        </ul>
                    </nav>   
                </header>
    </body>


</html>

<main>
            <div class="mainvisual">    <!-- 視覺主圖設定-->
                <img src="img/1.jfif">
            </div>
 </main>

 <article id="profile">  <!-- 第一個articl區塊，命名為profile-->
               <div class="content">  <!-- 設定固定寬度-->
                <h2>目前進度</h2>
                <p>《輝夜姬想讓人告白～天才們的戀愛頭腦戰～》（日語：かぐや様は告らせたい〜天才たちの恋愛頭脳戦〜），官方簡稱《輝夜姬》（日語：かぐや様），是日本漫畫家赤坂明的校園漫畫作品，起初於日本漫畫雜誌《Miracle Jump》2015年6月號至2016年2月號連載；後移籍至《週刊YOUNG JUMP》，於2016年17號開始連載。漫畫被改編為各種系列的衍生作品，包括同名的動畫、電影、小說等周邊媒體產品。</p>
               </div>
            </article>

            <div class="slider_container">
	<div>
		<img src="img/1.png" alt="pure css3 slider" />
		<span class="info">Image Description 1</span>
	</div>
	<div>
		<img src="img/3.jpg" alt="pure css3 slider" />
		<span class="info">Image Description 2</span>
	</div>
	<div>
		<img src="img/4.jpg" alt="pure css3 slider" />
		<span class="info">Image Description 3</span>
	</div>
</div>
 


