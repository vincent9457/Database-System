<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $topic = $_POST['topic'];
    $organizer = $_POST['organizer'];

    $stmt = mysqli_prepare($link, "INSERT INTO Speech (teacher_id, date, topic, organizer) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'isss', $teacher_id, $date, $topic, $organizer);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: speech_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>新增演講</title>
    <link rel="stylesheet" href="speech_insert_style.css">
</head>
<body>
<div class ="container">
<h2>➕ 新增校內外演講</h2>
<form method="post">
    日期：<input type="date" name="date" required><br><br>
    主題：<input type="text" name="topic" required><br><br>
    主辦單位：<input type="text" name="organizer" required><br><br>
    <input type="submit" value="確認送出" class="btn">
</form>
<p><a href="speech_list.php" class="btn-outline">返回演講列表</a></p>
</div>
</body>
</html>
