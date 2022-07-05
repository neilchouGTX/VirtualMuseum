<?php
    require_once("connMysql.php");
    session_start();
    // echo str_pad(1,8,"0",STR_PAD_LEFT)."</br>";
    // echo str_pad(12,8,"0",STR_PAD_LEFT)."</br>";
    // echo str_pad(123,8,"0",STR_PAD_LEFT)."</br>";
    if(isset($_POST["city"]) && isset($_POST["school_type"])  && isset($_POST["school_name"])){
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
            PRIMARY KEY(branch)
            );";       
        if ($conn->query($sql) === TRUE) {
            echo "Table ".$school_id."_branch created successfully\n";
        } else {
            echo "Table ".$school_id."_branch created error: ".$conn->error;
        }

        $sql = "CREATE TABLE ".$school_id."_image_attribute";
        $sql = $sql."(
            image_id int NOT NULL AUTO_INCREMENT,
            uploader VARCHAR(20),
            image_title VARCHAR(100),
            image_path VARCHAR(500),
            voice_title VARCHAR(100),
            voice_path VARCHAR(500),
            PRIMARY KEY(image_id),
            FOREIGN KEY(uploader) REFERENCES `user_account`(username)
            );";       
        if ($conn->query($sql) === TRUE) {
            echo "Table ".$school_id."_image_attribute created successfully\n";
        } else {
            echo "Table ".$school_id."_image_attribute created error: ".$conn->error;
        }

        $sql = "CREATE TABLE ".$school_id."_exhibition_hall";
        $sql = $sql."(
            image_id int,
            branch VARCHAR(50),
            art_place VARCHAR(10),
            FOREIGN KEY(image_id) REFERENCES `".$school_id."_image_attribute`(image_id),
            FOREIGN KEY(branch) REFERENCES `".$school_id."_branch`(branch),
            FOREIGN KEY(art_place) REFERENCES `museum_hall`(art_place),
            PRIMARY KEY(branch,art_place)
            );";       
        if ($conn->query($sql) === TRUE) {
            echo "Table ".$school_id."_exhibition_hall created successfully\n";
        } else {
            echo "Table ".$school_id."_exhibition_hall created error: ".$conn->error;
        }

        $sql = "CREATE TABLE ".$school_id."_image_data";
        $sql = $sql."(
            image_id int,
            art_name VARCHAR(50),
            art_author VARCHAR(50),
            art_description VARCHAR(100),
            author_class VARCHAR(50),
            art_upload_time DATETIME,
            PRIMARY KEY(image_id),
            FOREIGN KEY(image_id) REFERENCES `".$school_id."_image_attribute`(image_id),
            FOREIGN KEY(author_class) REFERENCES `".$school_id."_branch`(branch)
            );";       
        if ($conn->query($sql) === TRUE) {
            echo "Table ".$school_id."_image_data created successfully\n";
        } else {
            echo "Table ".$school_id."_image_data created error: ".$conn->error;
        }

        $_SESSION["school_id"] = $school_id;
        //sleep(3);
        header('location:registerAccount.php');
    }
  
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">    
        <title>註冊系統</title>
    </head>
    <body align = center>
        <h1>註冊系統</h1>
        <form method="post">
            <p>
                縣市:
                </br>
                <select name="city">
                    <option value="A台北市" selected>台北市</option>
                    <option value="F新北市">新北市</option>
                    <option value="B台中市">台中市</option>
                    <option value="V台東縣">台東縣</option>
                </select>
                </br>
                學校屬性:
                </br>
                <select name="school_type">
                    <option value="E國小" selected>國小</option>
                    <option value="J國中">國中</option>
                    <option value="H高中">高中</option>
                    <option value="U大學">大學</option>
                </select>
                </br>
                學校名稱:
                </br>
                <input name="school_name" type="text" required="required">
                </br>
                <input type="submit" name="button" id="button" value="註冊">
                </br>
            </p>
        </form>
    </body>
</html>