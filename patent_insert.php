<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $type = $_POST['type'];
    $number = $_POST['number'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $stmt = mysqli_prepare($link, "INSERT INTO Patent (teacher_id, title, type, number, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'isssss', $teacher_id, $title, $type, $number, $start_date, $end_date);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: patent_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>新增專利</title>
    <link rel="stylesheet" href="patent_insert_style.css">
    <script>
    function checkPatentDate() {
        var start = document.querySelector('input[name="start_date"]').value;
        var end = document.querySelector('input[name="end_date"]').value;
        if (start && end && end < start) {
            alert("❌ 結束日不可早於起始日！");
            return false;
        }
        return true;
    }
    </script>
</head>
<body>
<div class="container">
<h2>➕ 新增專利</h2>
<form method="post" onsubmit="return checkPatentDate();">
    標題：<input type="text" name="title" required><br><br>
    類型：<input type="text" name="type" required><br><br>
    專利號碼：<input type="text" name="number" required><br><br>
    起始日：<input type="date" name="start_date"><br><br>
    結束日：<input type="date" name="end_date"><br><br>
    <input type="submit" value="確認送出" class="btn">
</form>
<p><a href="patent_list.php" class="btn-outline">返回列表</a></p>
</div>
</body>
</html>
