<?php
    require_once("connMysql.php");
    session_start();
    if((!isset($_SESSION["username"])) || ($_SESSION["username"]=="") || ($_SESSION["permission"]==2)){
        header("Location: index.php");
    }
    $sql = "SELECT `school_id` FROM `user_account` WHERE username='".$_SESSION["username"]."'";
    $result = $conn->query($sql)->fetch_assoc();
    $school_id = $result["school_id"];

    if(isset($_POST["name"]) && isset($_POST["username"]) && isset($_POST["pwd"])){
        $sql = "SELECT COUNT(`username`) FROM `user_account` WHERE school_id ='".$school_id."'";
        $result = $conn->query($sql)->fetch_assoc();
        if($result["COUNT(`username`)"] >= 4){
            header("refresh:3;url=member.php");
            echo "<h1>已加滿三個附屬成員，無法再加入了</h1>";
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO `user_account` (school_id, username, name, password, position, permission) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $p_school_id, $p_username, $p_name, $p_password, $p_position, $p_permission);

        $p_school_id = $school_id;
        $p_username = $_POST["username"];
        $p_name = $_POST["name"];
        $p_password = $_POST["pwd"];
        $p_position = $_POST["position"];
        $p_permission = 2;
        $stmt->execute();
        echo "insert success";
        //sleep(2);
        header('location:index.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>虛擬美術館-註冊系統</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/mainTheme.css" rel="stylesheet" type="text/css"> 
    </head>
    <body>
        <header>
        <a href="index.php"><div class="logodiv"><img id="logoPic" src="img/newLogo.png"/></div></a>
            <nav>
                <ul class="flex-nav">
                    <li><a href="index.php">首頁</a></li>
                    <li><a href='member.php'>會員</a></li>
                    <li><a href='index.php?logout=1'>登出</a></li>
                    <li><a href="#">介紹</a></li>
                    <li><a href="#">關於我們</a></li>
                </ul>
            </nav>   
        </header>
        <form method="post" align="center">
            <p>
                學校ID:
                <input name="" type="text" disabled="disabled" value="<?php echo $school_id ?>">
                姓名:
                <input name="name" type="text" pattern="^[\w\u4e00-\u9fa5 ]+$" maxlength="50" required="required">
                職位:
                <input name="position" type="text" pattern="^[\w\u4e00-\u9fa5 ]+$" maxlength="50" required="required">
                帳號:
                <input name="username" type="text" pattern="^[\w@\.]+$" maxlength="100" required="required" required="required" >
                密碼:
                <input name="pwd" type="password" pattern="^[\w]+$" maxlength="50" required="required">
                <input type="submit" name="button" id="button" value="註冊">
            </p>
        </form>
        <table style='border:3px #cccccc solid;' cellpadding='10' border='1' align=center >
        <?php 
            $sql = "SELECT `username`,`permission` FROM `user_account` WHERE school_id ='".$school_id."'";
            $result = $conn->query($sql);
            echo "<tr>";
            echo "<th>已新增成員</th><th>權限等級</th>";
            echo "</tr>";
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>";
                echo $row["username"];
                echo "</td>";
                echo "<td>";
                if($row["permission"]==1)
                    echo "學校總管理員";
                else
                    echo "學校成員";
                echo "</td>";
                echo "</tr>";
            }
        ?>
        </table>
    </body>
</html>    