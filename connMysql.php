<?php
	//資料庫主機設定
	$db_host = "localhost";
	$db_username = "root";
	$db_password = "1990";
	$db_name = "museum";
	//連線資料庫
	$conn = @new mysqli($db_host, $db_username, $db_password, $db_name);
	//錯誤處理
	if ($conn->connect_error != "") {
		echo "資料庫連結失敗！";
	}else{
		//設定字元集與編碼
		$conn->query("SET NAMES 'utf8'");
		//echo "資料連接成成功よろしくお願いいたしますUTF-8 TEST</br>";
	}
?>