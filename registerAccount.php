<!--
    ABANDON!!    
    this php file is abandon from 7/12
    ABANDON!!
-->
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
                <input name="" type="text" disabled="disabled" value="<?php echo $_SESSION["school_id"] ?>">
                姓名:
                <input name="name" type="text" required="required">
                職位:
                <input name="position" type="text" >
                帳號:
                <input name="username" type="text" required="required">
                密碼:
                <input name="pwd" type="password" required="required">
                <input type="submit" name="button" id="button" value="註冊">
            </p>
        </form>
    </body>
</html>    