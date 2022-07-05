<?php
    require_once("connMysql.php");
    session_start();
    if(isset($_POST["name"]) && isset($_POST["username"]) && isset($_POST["pwd"])){
        $stmt = $conn->prepare("INSERT INTO `user_account` (school_id, username, name, password, position) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $p_school_id, $p_username, $p_name, $p_password, $p_position);

        $p_school_id = $_SESSION["school_id"];
        $p_username = $_POST["username"];
        $p_name = $_POST["name"];
        $p_password = $_POST["pwd"];
        $p_position = $_POST["position"];
        $stmt->execute();
        echo "insert success";
        //sleep(2);
        header('location:index.php');
    }
?>
<!DOCTYPE html>
<html>
    <header>

    </header>
    <body>
        <form method="post" align="center">
            <p>
                學校ID:
                </br>
                <input name="" type="text" disabled="disabled" value="<?php echo $_SESSION["school_id"] ?>">
                </br>
                姓名:
                </br>
                <input name="name" type="text" required="required">
                </br>
                職位:
                </br>
                <input name="position" type="text" >
                </br>
                帳號:
                </br>
                <input name="username" type="text" required="required">
                </br>
                密碼:
                </br>
                <input name="pwd" type="password" required="required">
                </br>
                <input type="submit" name="button" id="button" value="註冊">
                </br>
            </p>
        </form>
    </body>
</html>    