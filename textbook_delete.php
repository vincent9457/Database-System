<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$textbook_id = $_GET['textbook_id'] ?? 0;

// 確認教材是否屬於該老師
$stmt = mysqli_prepare($link, "SELECT * FROM Textbook WHERE textbook_id = ? AND teacher_id = ?");
mysqli_stmt_bind_param($stmt, 'ii', $textbook_id, $teacher_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$textbook = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$textbook) {
    echo "<p style='color:red;'>找不到此教材或無權限</p><a href='textbook_list.php'>返回</a>";
    exit;
}

// 建議：刪除作者使用 prepared statement（更安全）
$del_auth_stmt = mysqli_prepare($link, "DELETE FROM TextbookAuthor WHERE textbook_id = ?");
mysqli_stmt_bind_param($del_auth_stmt, 'i', $textbook_id);
mysqli_stmt_execute($del_auth_stmt);
mysqli_stmt_close($del_auth_stmt);

// 刪除教材主資料
$stmt = mysqli_prepare($link, "DELETE FROM Textbook WHERE textbook_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $textbook_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: textbook_list.php");
exit;
?>
