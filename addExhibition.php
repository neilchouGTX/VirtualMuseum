<?php
    require_once("connMysql.php");
    session_start();
    date_default_timezone_set('Asia/Taipei');
    if((!isset($_SESSION["username"])) || ($_SESSION["username"]=="")){
        header("Location: index.php");
    }
    $sql = "SELECT `school_id`,`name` FROM `user_account` WHERE username='".$_SESSION["username"]."'";
    $row = $conn->query($sql)->fetch_assoc();
    $school_id =  $row["school_id"];
    $mySqlName =  $row["name"];
    
    if(isset($_POST["deleteExh"])){
        $preDelete = $_POST["deleteExh"];
        for($i=0; $i<count($preDelete); $i++){
            // $sql = "SELECT COUNT(`author_class`) FROM `".$school_id."_image_data`";
            // $result = $conn->query($sql)->fetch_assoc();
            // if($result["COUNT(`author_class`)"]>0){
            //     echo "<h1>請先刪除全部該班級的圖片</h1>";
            // }
            // else{
                $sql = "DELETE FROM `".$school_id."_exhibition_hall` WHERE exhibition_name='".$preDelete[$i]."'";
                $conn->query($sql);
                $sql = "DELETE FROM `".$school_id."_exhibition_name` WHERE exhibition_name='".$preDelete[$i]."'";
                $conn->query($sql);
                header("Location: addExhibition.php");
            // }
        }
    }
    
    if(isset($_POST["addExh"]) && isset($_POST["addMuseum"])){
        // $branchMerge = $_POST["branchYear"]."*".$_POST["addBranch"];
        $phpDateTime = date ('Y-m-d H:i:s T');
        $sql = "INSERT INTO `".$school_id."_exhibition_name`(exhibition_name,exhibition_museum,exhibition_name_create_time) VALUES('".$_POST["addExh"]."','".$_POST["addMuseum"]."','".$phpDateTime."')";
        try{
            if($conn->query($sql)){
                echo "insert success";
                // $sql = "SELECT `art_place` FROM `museum_hall`";
                // $result = $conn->query($sql);
                // while($row = $result->fetch_assoc()){
                //     $sqlInsert = "INSERT INTO `".$school_id."_exhibition_hall`(branch,art_place) VALUES('".$branchMerge."','".$row["art_place"]."')";
                //     $conn->query($sqlInsert);
                // }
                
            }
            else{
                throw new Exception($conn->query($sql));
            }
        }
        catch(Exception $e){
            if(substr($e->getMessage(),0,15)=="Duplicate entry")
                echo "重複輸入";
            else{
                echo $e->getMessage();
            }
        } 
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>虛擬美術館-編輯美術館</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/mainTheme.css" rel="stylesheet" type="text/css"> 
        <style>
            th,td{
                padding:20px;   
            }
        </style>
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
        <h2>新增班級:</h2>

        <form method='post'>
            美術館名稱:<input type='text' name='addExh' pattern="^[\w\u4e00-\u9fa5 ]+$" maxlength="40" required="required"/>
            <?php
                $sql = "SELECT DISTINCT `exhibition_hall` FROM `museum_hall`";
                $result = $conn->query($sql);
                echo "<select name='addMuseum'>";
                while($row = $result->fetch_assoc()){
                    echo "<option value='".$row["exhibition_hall"]."'>".$row["exhibition_hall"]."</option>";
                }
                echo "</select>";
            ?>
            <button type='submit'>增加</button>
        </form>
        </br>
        <p>已增加名單</p>
        <form method='post'>
        <table style='border:3px #cccccc solid;' cellpadding='10' border='1' align=center >
            <tr>
                <th>美術館名稱</th><th>美術館</th><th>創立日期</th><th>刪除</th>
            </tr>
            
            <?php
                $sql = "SELECT `exhibition_name`,`exhibition_museum`,`exhibition_name_create_time` FROM `".$school_id."_exhibition_name`";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>";
                    echo $row["exhibition_name"];
                    echo "</td>";
                    echo "<td>";
                    echo $row["exhibition_museum"];
                    echo "</td>";
                    echo "<td>";
                    echo $row["exhibition_name_create_time"];
                    echo "</td>";
                    echo "<td>";
                    echo "<input type='checkbox' name='deleteExh[]' value='".$row["exhibition_name"]."' />";
                    echo "</td>";
                    echo "</tr>";
                }
                // echo "<button type='submit'>刪除</button>";
                // echo "</form>";
            ?>
        </table>
        <button type='submit'>刪除</button>
        </form>
    </body>
</html>