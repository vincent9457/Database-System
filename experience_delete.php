<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$category = trim($_GET['category'] ?? '');
$organization = trim($_GET['organization'] ?? '');
$role = trim($_GET['role'] ?? '');

if ($category === '' || $organization === '' || $role === '') {
    echo "<p style='color:red;'>缺少必要參數</p><a href='experience_list.php'>返回</a>";
    exit;
}

// 確認資料是否存在再刪除
$check = mysqli_prepare($link, "SELECT * FROM Experience WHERE teacher_id = ? AND category = ? AND organization = ? AND role = ?");
mysqli_stmt_bind_param($check, 'isss', $teacher_id, $category, $organization, $role);
mysqli_stmt_execute($check);
$result = mysqli_stmt_get_result($check);
$exists = mysqli_fetch_assoc($result);
mysqli_stmt_close($check);

if (!$exists) {
    echo "<p style='color:red;'>查無此經歷資料，無法刪除</p><a href='experience_list.php'>返回</a>";
    exit;
}

// 執行刪除
$stmt = mysqli_prepare($link, "DELETE FROM Experience WHERE teacher_id = ? AND category = ? AND organization = ? AND role = ?");
mysqli_stmt_bind_param($stmt, 'isss', $teacher_id, $category, $organization, $role);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: experience_list.php");
exit;
?>
