<?php
    require_once("connMysql.php");
    session_start();
    $usernameDuplicate = False;
    if(!isset($_SESSION["username"]) || ($_SESSION["username"]=="") || $_SESSION["permission"]!=0 ){
        header('location:index.php');
    }
    if(isset($_POST["name"]) && isset($_POST["username"]) && isset($_POST["pwd"])){
        $sql = "SELECT COUNT(`username`) FROM `user_account` WHERE username='".$_POST["username"]."'";
        $row = $conn->query($sql)->fetch_assoc();
        if($row["COUNT(`username`)"]!=0){
            echo "<script type='text/javascript'>alert('same username');</script>";
            $usernameDuplicate = True;
        }
    }
    if(isset($_POST["city"]) && isset($_POST["school_type"])  && isset($_POST["school_name"]) && !$usernameDuplicate){
        $data_count = 0;
        $sql = "SELECT COUNT(*) FROM `city_table`";
        $result = $conn->query($sql);
        while($row = $result->fetch_row()) {
            $data_count = (int)$row[0] + 1;
        }
        $result->close();

        $stmt = $conn->prepare("INSERT INTO `city_table` (school_id, city, type, name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $p_school_id, $p_city, $p_type, $p_name);
        $p_city = substr($_POST["city"],1);
        $p_type = substr($_POST["school_type"],1);
        $p_name = $_POST["school_name"];
        $p_school_id = substr($_POST["city"],0,1).substr($_POST["school_type"],0,1).str_pad($data_count,4,"0",STR_PAD_LEFT);
        $stmt->execute();
        echo "insert success";
        
        $school_id = $p_school_id;

        $sql = "CREATE TABLE ".$school_id."_branch";
        $sql = $sql."(
            branch VARCHAR(50),
            branch_create_time DATETIME,
            PRIMARY KEY(branch)
            );";       
        if ($conn->query($sql) === TRUE) {
            echo "Table ".$school_id."_branch created successfully\n";
        } else {
            echo "Table ".$school_id."_branch created error: ".$conn->error;
        }

        $sql = "CREATE TABLE ".$school_id."_exhibition_name";
        $sql = $sql."(
            exhibition_name VARCHAR(50),
            exhibition_museum VARCHAR(30),
            exhibition_name_create_time DATETIME,
            PRIMARY KEY(exhibition_name)
            );";       
        if ($conn->query($sql) === TRUE) {
            echo "Table ".$school_id."_branch created successfully\n";
        } else {
            echo "Table ".$school_id."_branch created error: ".$conn->error;
        }

        $sql = "CREATE TABLE ".$school_id."_image_attribute";
        $sql = $sql."(
            image_id VARCHAR(15) NOT NULL,
            uploader VARCHAR(20),
            image_title VARCHAR(300),
            image_path VARCHAR(500),
            voice_title VARCHAR(300),
            voice_path VARCHAR(500),
            PRIMARY KEY(image_id)
            );";       
        if ($conn->query($sql) === TRUE) {
            echo "Table ".$school_id."_image_attribute created successfully\n";
        } else {
            echo "Table ".$school_id."_image_attribute created error: ".$conn->error;
        }

        $sql = "CREATE TABLE ".$school_id."_exhibition_hall";
        $sql = $sql."(
            image_id VARCHAR(15),
            exhibition_name VARCHAR(50),
            art_place VARCHAR(10),
            FOREIGN KEY(image_id) REFERENCES `".$school_id."_image_attribute`(image_id),
            FOREIGN KEY(art_place) REFERENCES `museum_hall`(art_place),
            PRIMARY KEY(exhibition_name,art_place)
            );";       
        if ($conn->query($sql) === TRUE) {
            echo "Table ".$school_id."_exhibition_hall created successfully\n";
        } else {
            echo "Table ".$school_id."_exhibition_hall created error: ".$conn->error;
        }

        $sql = "CREATE TABLE ".$school_id."_image_data";
        $sql = $sql."(
            image_id VARCHAR(15),
            art_name VARCHAR(50),
            art_author VARCHAR(50),
            art_description VARCHAR(500),
            author_class VARCHAR(50),
            art_upload_time DATETIME,
            PRIMARY KEY(image_id),
            FOREIGN KEY(image_id) REFERENCES `".$school_id."_image_attribute`(image_id)
            );";       
        if ($conn->query($sql) === TRUE) {
            echo "Table ".$school_id."_image_data created successfully\n";
        } else {
            echo "Table ".$school_id."_image_data created error: ".$conn->error;
        }

        $_SESSION["school_id"] = $school_id;
        //sleep(3);
        // header('location:registerAccount.php');

        $stmt = $conn->prepare("INSERT INTO `user_account` (school_id, username, name, password, position, permission, manager) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $p_school_id, $p_username, $p_name, $p_password, $p_position, $p_permission, $p_manager);

        $p_school_id = $school_id;
        $p_username = $_POST["username"];
        $p_name = $_POST["name"];
        $p_password = $_POST["pwd"];
        $p_position = $_POST["position"];
        $p_permission = 1;
        $p_manager = "supervisor";
        $stmt->execute();
        echo "insert success";

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
        <link href="css/registerSchool.css" rel="stylesheet" type="text/css"> 
    </head>
    <body align = center>
        <header>
        <a href="index.php"><div class="logodiv"><img id="logoPic" src="img/newLogo.png"/></div></a>
            <nav>
                <ul class="flex-nav">
                    <li><a href="index.php">首頁</a></li>
                    <li><a href='member.php'>會員</a></li>
                    <li><a href='index.php?logout=1'>登出</a></li>
                    <li><a href="introduction.php">介紹</a></li>
                    <li><a href="aboutUs.php">關於我們</a></li>
                </ul>
            </nav>   
        </header>
        <h1>註冊系統</h1>
        <form method="post">
            <div class='registerDiv'>
                <h2>縣市:</h2>
                <select name="city">
                    <option value="A台北市" selected>台北市</option>
                    <option value="B台中市">台中市</option>
                    <option value="C基隆市">基隆市</option>
                    <option value="D台南市">台南市</option>
                    <option value="E高雄市">高雄市</option>
                    <option value="F新北市">新北市</option>
                    <option value="G宜蘭縣">宜蘭縣</option>
                    <option value="H桃園市">桃園市</option>
                    <option value="I嘉義市">嘉義市</option>
                    <option value="J新竹縣">新竹縣</option>
                    <option value="K苗栗縣">苗栗縣</option>
                    <option value="M南投縣">南投縣</option>
                    <option value="N彰化縣">彰化縣</option>
                    <option value="O新竹市">新竹市</option>
                    <option value="P雲林縣">雲林縣</option>
                    <option value="Q嘉義縣">嘉義縣</option>
                    <option value="T屏東縣">屏東縣</option>
                    <option value="U花蓮縣">花蓮縣</option>
                    <option value="V台東縣">台東縣</option>
                    <option value="W金門縣">金門縣</option>
                    <option value="X澎湖縣">澎湖縣</option>
                    <option value="Z連江縣">連江縣</option>
                </select>
                <h2>學校屬性:</h2>
                <select name="school_type">
                    <option value="E國小" selected>國小</option>
                    <option value="J國中">國中</option>
                    <option value="H高中">高中</option>
                    <option value="U大學">大學</option>
                </select>
                <h2>學校名稱:</h2>
                <input name="school_name" type="text" required="required" pattern="^[\w\u4e00-\u9fa5 ]+$" maxlength="50">
                <h2>電子郵件:</h2>
                <input name="username" type="email" maxlength="100" required="required">
                <h2>密碼:</h2>
                <input name="pwd" type="password" pattern="^[\w]+$" maxlength="50" required="required">
                <h2>姓名:</h2>
                <input name="name" type="text" pattern="^[\w\u4e00-\u9fa5 ]+$" maxlength="50" required="required">
                <h2>職位:</h2>
                <input name="position" type="text" pattern="^[\w\u4e00-\u9fa5 ]+$" maxlength="50" required="required">
                <input type="submit" name="button" id="button" value="註冊">
            </div>
        </form>
    </body>
</html>