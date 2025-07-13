<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $publisher = trim($_POST['publisher']);
    $authors_input = trim($_POST['authors']);
    $authors = array_filter(array_map('trim', explode(',', $authors_input)));

    // 新增教材主資料
    $stmt = mysqli_prepare($link, "INSERT INTO Textbook (teacher_id, name, publisher) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("資料庫錯誤：" . mysqli_error($link));
    }
    mysqli_stmt_bind_param($stmt, 'iss', $teacher_id, $name, $publisher);
    mysqli_stmt_execute($stmt);
    $textbook_id = mysqli_insert_id($link);
    mysqli_stmt_close($stmt);

    // 新增作者資料
    foreach ($authors as $author) {
        $stmt2 = mysqli_prepare($link, "INSERT INTO TextbookAuthor (textbook_id, author) VALUES (?, ?)");
        if ($stmt2) {
            mysqli_stmt_bind_param($stmt2, 'is', $textbook_id, $author);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt2);
        }
    }

    header("Location: textbook_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>新增教材</title>
    <link rel="stylesheet" href="textbook_insert_style.css">
</head>
<body>
<div class="container">
<h2>➕ 新增教材資料</h2>
<form method="post">
    教材名稱：<input type="text" name="name" required><br><br>
    出版社：<input type="text" name="publisher" required><br><br>
    作者（用逗號分隔）：<input type="text" name="authors" required><br><br>
    <input type="submit" value="確認送出" class="btn">
</form>
<p><a href="textbook_list.php" class="btn-outline">返回教材列表</a></p>
</div>
</body>
</html>
