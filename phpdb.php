<?php
$host = 'localhost:3306';     
$dbuser = 'D1248993';         
$dbpassword = '#n4VKxHzp';    
$dbname = 'D1248993';         

$link = mysqli_connect($host, $dbuser, $dbpassword, $dbname);

if ($link) {
    mysqli_query($link, "SET NAMES utf8mb4");
    // echo "connected";
} else {
    echo "❌ 資料庫連線失敗：" . mysqli_connect_error();
}
?>
