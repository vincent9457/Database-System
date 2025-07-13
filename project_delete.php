<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$project_id = $_GET['project_id'] ?? 0;

// 確認此 project 是此教師的
$stmt = mysqli_prepare($link, "SELECT category FROM Project WHERE project_id = ? AND teacher_id = ?");
mysqli_stmt_bind_param($stmt, 'ii', $project_id, $teacher_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row) {
    echo "<p style='color:red;'>⚠️ 無此計畫或您無權刪除</p><a href='project_list.php'>返回</a>";
    exit;
}

$category = $row['category'];

// 刪除子表資料
if ($category === '國科會計畫') {
    mysqli_query($link, "DELETE FROM NSTCProject WHERE project_id = $project_id");
} elseif ($category === '產學合作') {
    mysqli_query($link, "DELETE FROM IndustryProject WHERE project_id = $project_id");
}

// 刪除主表資料
$stmt = mysqli_prepare($link, "DELETE FROM Project WHERE project_id = ? AND teacher_id = ?");
mysqli_stmt_bind_param($stmt, 'ii', $project_id, $teacher_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: project_list.php");
exit;
?>
