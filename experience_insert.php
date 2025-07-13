<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $organization = $_POST['organization'];
    $role = $_POST['role'];
    $school = $_POST['school'];

    $stmt = mysqli_prepare($link, "INSERT INTO Experience (teacher_id, category, organization, role, school) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'issss', $teacher_id, $category, $organization, $role, $school);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: experience_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>新增經歷</title>
    <link rel="stylesheet" href="experience_insert_style.css">
</head>
<body>
<div class="container">
<h2>➕ 新增經歷資料</h2>
<form method="post">
    類別：
    <select name="category" required>
        <option value="">--請選擇--</option>
        <option value="校內">校內</option>
        <option value="校外">校外</option>
    </select><br><br>

    任職單位：<input type="text" name="organization" required><br><br>
    職稱：<input type="text" name="role" required><br><br>
    所屬學校：<input type="text" name="school"><br><br>

    <input type="submit" value="確認送出" class="btn">
</form>
<p><a href="experience_list.php" class="btn-outline">返回經歷列表</a></p>
</div>
</body>
</html>
