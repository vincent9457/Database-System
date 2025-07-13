<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$date = $_GET['date'] ?? '';
$topic = $_GET['topic'] ?? '';

if (!$date || !$topic) {
    echo "<p style='color:red;'>缺少必要參數</p><a href='speech_list.php'>返回</a>";
    exit;
}

// 刪除演講資料
$stmt = mysqli_prepare($link, "DELETE FROM Speech WHERE teacher_id = ? AND date = ? AND topic = ?");
mysqli_stmt_bind_param($stmt, 'iss', $teacher_id, $date, $topic);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: speech_list.php");
exit;
?>
