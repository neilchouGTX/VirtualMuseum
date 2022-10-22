<?php
    // echo $_SERVER["SCRIPT_FILENAME"]."</br>";
    // echo basename($_SERVER["SCRIPT_FILENAME"],".php");
    // if(isset($_FILES["upload"]["name"])){
    //     $total_count = count($_FILES['upload']['name']);
    //     for($i=0; $i<$total_count; $i++){
    //         if(move_uploaded_file($_FILES["upload"]["tmp_name"][$i],"test/".$_FILES["upload"]["name"][$i])){
    //             echo "upload success</br>";
    //             echo $_FILES["upload"]["tmp_name"][$i]."</br>";
    //             echo $_FILES["upload"]["name"][$i]."</br>";
    //             echo "------------------------------"."</br>";
    //         }
    //         else{
    //             echo "uplaod failed";
    //         }
    //     }
        
    // }
    
?>
<html>
    <head>

    </head>
    <body>
        <form method="post" enctype="multipart/form-data">
            <input name="upload[]" type="file" multiple="multiple"/>
            <input type="submit" value="送出"/>
        </form>
    </body>
</html>
