<?php
    require_once("connMysql.php");
    session_start();
    date_default_timezone_set('Asia/Taipei');
    if((!isset($_SESSION["username"])) || ($_SESSION["username"]=="")){
        header("Location: index.php");
    }
    $stmt = $conn->prepare("SELECT `school_id`,`name` FROM `user_account` WHERE username=?");
    $stmt -> bind_param("s",$_SESSION["username"]); 
    $stmt -> execute();
    $stmt -> bind_result($school_id,$mySqlName);
    $stmt -> fetch();
    $stmt -> close();
    $username = $_SESSION["username"];

    $sql = "SELECT COUNT(`branch`) FROM `".$school_id."_branch`";
    $result = $conn->query($sql)->fetch_assoc();
    if($result["COUNT(`branch`)"]==0){
        header("refresh:3;url=branch.php");
        echo "<h1>請先新增至少一個班級，即將跳轉...</h1>";
        exit();
    }    
    $dateOfToday = date('Ymd');
    if(!file_exists("image/$school_id/")){
        mkdir("image/$school_id",0755);
    }
    if(!file_exists("image/$school_id/$username")){
        mkdir("image/$school_id/$username",0755);
    }
    if(!file_exists("image/$school_id/$username/$dateOfToday")){
        mkdir("image/$school_id/$username/$dateOfToday",0755);
    }
    if(isset($_POST["action"])){
        if($_POST["action"]=="delete"){
            $preDelete = $_POST["deletePictureID"];
            for($i=0; $i<count($preDelete); $i++){
                unlink($_POST["deletePicturePath"][$preDelete[$i]]);
                $sql = "SELECT `art_place` FROM `$school_id"."_exhibition_hall` WHERE image_id='$preDelete[$i]' ";
                $result = $conn->query($sql);
                if(isset($result)){
                    while($row = $result->fetch_assoc()){
                        $sql = "UPDATE `$school_id"."_exhibition_hall` SET image_id=NULL WHERE art_place='".$row["art_place"]."'";
                        $conn->query($sql);
                    }
                }

                $stmt = $conn->prepare("DELETE FROM `$school_id"."_image_data` WHERE image_id= ?");
                $stmt -> bind_param("s",$preDelete[$i]);
                $stmt -> execute();
                $stmt -> close();

                $stmt = $conn->prepare("DELETE FROM `$school_id"."_image_attribute` WHERE image_id= ?");
                $stmt -> bind_param("s",$preDelete[$i]);
                $stmt -> execute();
                $stmt -> close();
                header("Location: imageUploader.php");
            }
        }
        else if($_POST["action"]=="update"){
            $preUpdate = $_POST["updateArtName"];
            foreach($preUpdate as $updateID => $updateValue ){
                if($updateValue!=""){
                    $sql = "UPDATE `$school_id"."_image_data` SET art_name='$updateValue' WHERE image_id='$updateID'";
                    $conn->query($sql);
                }
            }
            $preUpdate = $_POST["updateArtAuthor"];
            foreach($preUpdate as $updateID => $updateValue ){
                if($updateValue!=""){
                $sql = "UPDATE `$school_id"."_image_data` SET art_author='$updateValue' WHERE image_id='$updateID'";
                $conn->query($sql);
                }
            }
            $preUpdate = $_POST["updateArtDescription"];
            foreach($preUpdate as $updateID => $updateValue ){
                if($updateValue!=""){
                $sql = "UPDATE `$school_id"."_image_data` SET art_description='$updateValue' WHERE image_id='$updateID'";
                $conn->query($sql);
                }
            }
            $preUpdate = $_POST["updateAuthorClass"];
            foreach($preUpdate as $updateID => $updateValue ){
                if($updateValue!=""){
                $sql = "UPDATE `$school_id"."_image_data` SET author_class='$updateValue' WHERE image_id='$updateID'";
                $conn->query($sql);
                }
            }
            $preUpdate = $_POST["updateArtPlace"];
            foreach($preUpdate as $updateID => $updateValue ){
                if($updateValue!=""){
                    if($updateValue=="remove"){
                        $sql = "SELECT `art_place` FROM `$school_id"."_exhibition_hall` WHERE image_id='$updateID' ";
                        $result = $conn->query($sql);
                        if(isset($result)){
                            while($row = $result->fetch_assoc()){
                                $sql = "UPDATE `$school_id"."_exhibition_hall` SET image_id=NULL WHERE art_place='".$row["art_place"]."'";
                                $conn->query($sql);
                            }
                        }
                    }
                    else{
                        $sql = "SELECT `author_class` FROM `$school_id"."_image_data` WHERE image_id='$updateID'";
                        $row = $conn->query($sql)->fetch_assoc();

                        $sql = "UPDATE `$school_id"."_exhibition_hall` SET image_id='$updateID' WHERE art_place='$updateValue' AND branch='".$row["author_class"]."'";
                        $conn->query($sql);
                    }
                
                }
            }
            //print_r($preUpdate);
        }

    }
    // if(isset($_POST["deletePicture"])){
    //     unlink("image/$school_id/$username/".$_POST["deletePicture"]["title"]);
    //     $stmt = $conn->prepare("DELETE FROM `$school_id"."_image_data` WHERE image_id= ?");
    //     $stmt -> bind_param("s",$_POST["deletePicture"]["id"]);
    //     $stmt -> execute();
    //     $stmt -> close();

    //     $stmt = $conn->prepare("DELETE FROM `$school_id"."_image_attribute` WHERE image_id= ?");
    //     $stmt -> bind_param("s",$_POST["deletePicture"]["id"]);
    //     $stmt -> execute();
    //     $stmt -> close();
    //     header("Location: imageUploader.php");
    // }
    if(isset($_FILES["fileUpload"]["name"]) && $_FILES["fileUpload"]["error"][0]==0){
        $total_count = count($_FILES["fileUpload"]["name"]);
        $upload_flag = true;
        $dateOfToday = date('Ymd');
        $sqlCountToday = "SELECT `image_id` FROM $school_id"."_image_attribute WHERE `image_id` LIKE '".$dateOfToday."%' ORDER BY `image_id` DESC";
        $resultCountToday = $conn->query($sqlCountToday);
        $rowCountToday = $resultCountToday->fetch_assoc();
        if(!isset($rowCountToday["image_id"])){
            $numberOfToday=0;
        }
        else{
            $numberOfToday = explode("_",$rowCountToday["image_id"]);
            $numberOfToday =  $numberOfToday[1];
        }
        for($i=0; $i<$total_count; $i++){
            $_FILES["fileUpload"]["name"][$i] = str_replace(" ", "_", $_FILES["fileUpload"]["name"][$i]); 
            if(move_uploaded_file($_FILES["fileUpload"]["tmp_name"][$i],"image/$school_id/$username/$dateOfToday/".$_FILES["fileUpload"]["name"][$i])){
                $sqlCheckDuplicate = "SELECT COUNT(`image_title`) FROM $school_id"."_image_attribute WHERE `image_title`='".$_FILES["fileUpload"]["name"][$i]."'" ;
                $resultCheckDuplicate = $conn->query($sqlCheckDuplicate)->fetch_assoc();
                if($resultCheckDuplicate["COUNT(`image_title`)"]==0){
                    $stmt = $conn->prepare("INSERT INTO $school_id"."_image_attribute (image_id,uploader,image_title, image_path) VALUES (?,?,?,?);");
                    $stmt -> bind_param("ssss",$pre_image_id,$username,$_FILES["fileUpload"]["name"][$i],$dir);
                    $pre_image_id = $dateOfToday."_".str_pad(($numberOfToday+$i+1),4,"0",STR_PAD_LEFT);
                    $dir = "image/$school_id/$username/$dateOfToday/".$_FILES["fileUpload"]["name"][$i];
                    $stmt -> execute();
                    $stmt -> close();

                    $stmt = $conn->prepare("SELECT image_id FROM `$school_id"."_image_attribute` WHERE image_title=?");
                    $stmt -> bind_param("s",$_FILES["fileUpload"]["name"][$i]);
                    $stmt -> execute();
                    $stmt -> bind_result($fetch_image_id);
                    $stmt -> fetch();
                    $stmt -> close();

                    $stmt = $conn->prepare("INSERT INTO $school_id"."_image_data (image_id,art_upload_time) VALUES (?,?);");
                    $phpDateTime = date ('Y-m-d H:i:s T');
                    $stmt -> bind_param("ss",$fetch_image_id,$phpDateTime);
                    $stmt -> execute();
                    $stmt -> close();
                }
                else{
                    header("refresh:3;url=imageUploader.php");
                    echo "重複檔名(".$_FILES["fileUpload"]["name"][$i].")上傳...即將返回";
                    exit();
                }
            }
            else{
                $upload_flag = false;
            }
        }
        if($upload_flag)
            echo "upload success</br>";
        else
            echo "upload failed</br>";
        header("Location: imageUploader.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>虛擬美術館-圖片上傳</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/mainTheme.css" rel="stylesheet" type="text/css">
        <link href="css/imageUploader.css" rel="stylesheet" type="text/css">
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
        <input type="button" value="回首頁" onclick="location.href='index.php'">
        <input type="button" value="登出" onclick="location.href='index.php?logout=1'">
        
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="fileUpload[]" multiple="multiple"/>
            <br>
            <input type="submit" value="送出"/>
        </form>
        <p>
            <?php
                // $file=scandir("image/$username");
                // print_r($file);

                $sql = "SELECT `image_id`,`image_path`,`image_title` FROM `$school_id"."_image_attribute` WHERE uploader='$username'";
                $result = $conn->query($sql);

                $sqlArt = "SELECT * FROM `museum_hall`";
                $resultArt = $conn->query($sqlArt);

                $sqlBranch = "SELECT * FROM `$school_id"."_branch`";
                $resultBranch = $conn->query($sqlBranch);

                $data_count = 0;
                echo "<table style='border:3px #cccccc solid;' cellpadding='10' border='1' align=center>";
                echo "<tr><th>圖片資訊</th><th>圖片預覽</th><th>上傳日期</th><th>刪除</th><th>修改資料</th></tr>";
                echo "<form method='post'>";
                while($row = $result->fetch_assoc()) {
                    mysqli_data_seek($resultArt,0);
                    mysqli_data_seek($resultBranch,0);
                    echo "<tr>";
                    echo "<td>";
                    echo "<p id='picID' >圖片編號: ".$row["image_id"]."</br>"."圖片名稱: ".$row["image_title"]."</p>";
                    echo "</td>";
                    echo "<td>";
                    echo "<div class='imageDiv'>";
                    echo "<img class='image' src='".$row["image_path"]."' alt='a pic'>";
                    echo "</div>";
                    echo "</td>";
                    $sqlImageData = "SELECT `art_upload_time` FROM `$school_id"."_image_data` WHERE image_id='".$row["image_id"]."'";
                    $resultImageData = $conn->query($sqlImageData)->fetch_assoc();
                    echo "<td>";
                    echo $resultImageData["art_upload_time"];
                    echo "</td>";
                    echo "<td align = center>";
                    echo "<input type='checkbox' name='deletePictureID[]' value=".$row['image_id']." />
                            <input type='hidden' name='deletePicturePath[".$row['image_id']."]' value=".$row['image_path']." />";
                    echo "</td>";
                    echo "<td id='picData' align='left'>";
                    /*---------------------this is the start of inner table---------------------*/
                    echo "<table style='border:3px #cccccc solid;' border='1'>";
                    $sqlChooseData = "SELECT `art_name`,`art_author`,`art_description`,`author_class` FROM `$school_id"."_image_data` WHERE image_id='".$row["image_id"]."'";
                    $resultChooseData = $conn->query($sqlChooseData);
                    $rowChooseData = $resultChooseData->fetch_assoc();
                    echo "<tr>";
                    echo "<td>";
                    echo "作品名稱:";
                    echo "</td>";
                    echo "<td style='width:400px;'>";
                    echo "<input type='text' name='updateArtName[".$row["image_id"]."]' value='".$rowChooseData["art_name"]."' pattern='^[\w\u4e00-\u9fa5 ]+$' maxlength='50'/>";
                    echo "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td>";
                    echo "作者:";
                    echo "</td>";
                    echo "<td>";
                    echo "<input type='text' name='updateArtAuthor[".$row["image_id"]."]' value='".$rowChooseData["art_author"]."'  maxlength='50'/>";
                    echo "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td>";
                    echo "作品描述:";
                    echo "</td>";
                    echo "<td>";
                    echo "<textarea type='text' name='updateArtDescription[".$row["image_id"]."]'  maxlength='500'>".$rowChooseData["art_description"]."</textarea>";
                    echo "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td>";
                    echo "班級:";
                    echo "</td>";
                    echo "<td>";
                    echo "<input type='text' name='updateAuthorClass[".$row["image_id"]."]' value='".$rowChooseData["author_class"]."' disabled='disabled'/>";
                    echo "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td>";
                    echo "選擇班級:";
                    echo "</td>";
                    echo "<td>";
                    echo "<select name='updateAuthorClass[".$row["image_id"]."]'>";
                    while($rowBranch = $resultBranch->fetch_assoc()){
                        if($rowChooseData["author_class"] == $rowBranch["branch"])
                            echo "<option value='".$rowBranch["branch"]."' selected='selected'>".$rowBranch["branch"]."</option>";
                        else
                            echo "<option value='".$rowBranch["branch"]."'>".$rowBranch["branch"]."</option>";
                    }
                    echo "</select>";
                    echo "</td>";
                    echo "</tr>";
                    
                    echo "<tr>";
                    echo "<td>";
                    echo "選擇擺放位置:";
                    echo "</td>";
                    echo "<td>";
                    echo "<select name='updateArtPlace[".$row["image_id"]."]'>";
                    echo "<option value=''>預設</option>";
                    echo "<option value='remove'>全數移除</option>";
                    while($rowArt = $resultArt->fetch_assoc()){
                        echo "<option value='".$rowArt["art_place"]."'>".$rowArt["exhibition_hall"].$rowArt["art_place"]."</option>";
                    }
                    echo "</select>";
                    echo "</td>";
                    echo "</tr>";

                    $sqlFindHall = "SELECT `branch`,`art_place` FROM `$school_id"."_exhibition_hall` WHERE image_id='".$row['image_id']."'";
                    $resultFindHall = $conn->query($sqlFindHall);
                    echo "<tr>";
                    echo "<td>";
                    echo "已放置的畫框:";
                    echo "</td>";
                    echo "<td>";
                    while($rowFindHall = $resultFindHall->fetch_assoc()){
                        echo $rowFindHall["branch"]."班的".$rowFindHall["art_place"]."畫框</br>";
                    }
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                    /*---------------------this is the end of inner table---------------------*/
                    echo "</td>";
                    echo "</tr>";  
                    $data_count++;
                }
                echo "</table>";
                echo "<input name='data_count' type='hidden' value=$data_count></input>";
                echo "<button type='submit' name='action' value='delete'>刪除</button>";
                echo "<button type='submit' name='action' value='update'>更新資料</button>";
                echo "</form>";
                $result->close();
            ?>
        </p>
    </body>
</html>