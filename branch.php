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
    
    if(isset($_POST["deleteBranch"])){
        $preDelete = $_POST["deleteBranch"];
        for($i=0; $i<count($preDelete); $i++){
            $sql = "SELECT COUNT(`author_class`) FROM `".$school_id."_image_data`";
            $result = $conn->query($sql)->fetch_assoc();
            if($result["COUNT(`author_class`)"]>0){
                echo "<h1>請先刪除全部該班級的圖片</h1>";
            }
            else{
                $sql = "DELETE FROM `".$school_id."_exhibition_hall` WHERE branch='".$preDelete[$i]."'";
                $conn->query($sql);
                $sql = "DELETE FROM `".$school_id."_branch` WHERE branch='".$preDelete[$i]."'";
                $conn->query($sql);
                header("Location: branch.php");
            }
        }
    }
    
    if(isset($_POST["addBranch"])){
        $sql = "INSERT INTO `".$school_id."_branch`(branch) VALUES('".$_POST["addBranch"]."')";
        try{
            if($conn->query($sql)){
                echo "insert success";
                $sql = "SELECT `art_place` FROM `museum_hall`";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $sqlInsert = "INSERT INTO `".$school_id."_exhibition_hall`(branch,art_place) VALUES('".$_POST["addBranch"]."','".$row["art_place"]."')";
                    $conn->query($sqlInsert);
                }
                
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
        <title>虛擬美術館-編輯班級</title>
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
        <form method='post'>
            增加班級:<input type='text' name='addBranch' />
            <button type='submit'>增加</button>
        </form>
        </br>
        <p>已增加名單</p>
        <table style='border:3px #cccccc solid;' cellpadding='10' border='1' align=center >
            <tr>
                <th>班級</th><th>刪除</th>
            </tr>
            
            <?php
                $sql = "SELECT `branch` FROM `".$school_id."_branch`";
                $result = $conn->query($sql);
                echo "<form method='post'>";
                
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>";
                    echo $row["branch"];
                    echo "</td>";
                    echo "<td>";
                    echo "<input type='checkbox' name='deleteBranch[]' value='".$row["branch"]."' />";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "<button type='submit'>刪除</button>";
                echo "</form>";
            ?>
        </table>
    </body>
</html>