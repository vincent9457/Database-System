<?php
// register.php
session_start();
require_once 'phpdb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // 檢查 Teacher 是否存在
    $stmt = mysqli_prepare($link, "SELECT teacher_id FROM Teacher WHERE name = ? AND email = ?");
    mysqli_stmt_bind_param($stmt, 'ss', $name, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $teacher = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$teacher) {
        echo "<script>alert('找不到對應的教師資料，請確認姓名與 Email 是否正確。'); window.location.href='register.php';</script>";
    } else {
        $teacher_id = $teacher['teacher_id'];

        // 檢查是否該 teacher_id 已註冊過
        $check = mysqli_prepare($link, "SELECT * FROM Admin WHERE teacher_id = ?");
        mysqli_stmt_bind_param($check, 'i', $teacher_id);
        mysqli_stmt_execute($check);
        $res = mysqli_stmt_get_result($check);
        $teacher_registered = mysqli_fetch_assoc($res);
        mysqli_stmt_close($check);

        if ($teacher_registered) {
            echo "<script>alert('您已註冊過，請直接登入。'); window.location.href='login.php';</script>";
        } else {
            // 檢查 username 是否已存在
            $checkUser = mysqli_prepare($link, "SELECT * FROM Admin WHERE username = ?");
            mysqli_stmt_bind_param($checkUser, 's', $username);
            mysqli_stmt_execute($checkUser);
            $resUser = mysqli_stmt_get_result($checkUser);
            $username_exists = mysqli_fetch_assoc($resUser);
            mysqli_stmt_close($checkUser);

            if ($username_exists) {
                echo "<script>alert('此帳號已被使用，請選擇其他帳號。'); window.location.href='register.php';</script>";
            } else {
                // 安全寫入帳密
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $insert = mysqli_prepare($link, "INSERT INTO Admin (username, password, teacher_id) VALUES (?, ?, ?)");
                mysqli_stmt_bind_param($insert, 'ssi', $username, $hash, $teacher_id);

                if (mysqli_stmt_execute($insert)) {
                    echo "<script>alert('註冊成功，請前往登入頁面。'); window.location.href='login.php';</script>";
                } else {
                    echo "<script>alert('註冊失敗，請稍後再試。'); window.location.href='register.php';</script>";
                }
                mysqli_stmt_close($insert);
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>教師註冊</title>
    <link rel="stylesheet" href="register_style.css">
</head>
<body>
<div class="container">
  <h2>教師註冊</h2>
  <form method="post">
    <div class="form-group">
      <label for="name">姓名：</label>
      <input type="text" id="name" name="name" required>
    </div>

    <div class="form-group">
      <label for="email">Email：</label>
      <input type="email" id="email" name="email" required>
    </div>

    <div class="form-group">
      <label for="username">自訂帳號：</label>
      <input type="text" id="username" name="username" required>
    </div>

    <div class="form-group">
      <label for="password">密碼：</label>
      <input type="password" id="password" name="password" required>
    </div>

    <input type="submit" value="註冊">
  </form>
  <p><a href="login.php">已有帳號？點此登入</a></p>
</div>

</body>
</html>
