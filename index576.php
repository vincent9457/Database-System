<?php
session_start();

// 如果已登入，導向 dashboard.php
if (isset($_SESSION['teacher_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>教師後台首頁</title>
    <link rel="stylesheet" href="index576_style.css">
</head>
<body>
  <div class="container">
    <h2>歡迎使用教師後台系統</h2>
    <p>請先登入或註冊才能管理您的資料。</p>
        <a href="login.php">👉 登入（已註冊老師）</a>
        <a href="register.php">📝 註冊（第一次使用）</a>
  </div>
</body>
</html>

