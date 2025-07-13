<?php
session_start();
require_once 'phpdb.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo "<script>alert('請填寫帳號與密碼'); window.location.href='login.php';</script>";
    exit;
}

$stmt = mysqli_prepare($link, "SELECT * FROM Admin WHERE username = ?");
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['teacher_id'] = $user['teacher_id'];
    $_SESSION['username'] = $user['username'];
    // 如果帳號是 "Admin" 就視為管理員
    if ($user['username'] === 'Admin') {
        $_SESSION['admin'] = true;
        header('Location: select576.php');
    } else {
        $_SESSION['admin'] = false;
        header('Location: dashboard.php');
    }
    exit;
} else {
    echo "<script>alert('❗登入失敗：帳號或密碼錯誤。'); window.location.href='login.php';</script>";
    exit;
}
?>
