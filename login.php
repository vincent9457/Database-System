<?php
session_start();

// 如果已登入，導向首頁
if (isset($_SESSION['teacher_id'])) {
    header('Location: index576.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>教師登入</title>
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
    <div class="container">
        <h2>教師登入</h2>
        <form action="check_login.php" method="post">
            <div class="form-group">
                <label for="username">帳號：</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">密碼：</label>
                <input type="password" id="password" name="password" required>
            </div>
            <input type="submit" value="登入">
        </form>
        <p><a href="register.php">尚未註冊？點此建立帳號</a></p>
    </div>
</body>
</html>
