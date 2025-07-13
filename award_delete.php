<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$type = $_GET['type'] ?? '';
$name = $_GET['name'] ?? '';
$date = $_GET['date'] ?? '';

if (!in_array($type, ['internal', 'external'])) {
    echo "<p style='color:red;'>錯誤的類型參數</p><a href='award_list.php'>返回</a>";
    exit;
}

if ($type === 'internal') {
    $stmt = mysqli_prepare($link, "DELETE FROM InternalAward WHERE teacher_id = ? AND name = ? AND award_date = ?");
    mysqli_stmt_bind_param($stmt, 'iss', $teacher_id, $name, $date);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
} else {
    // 先刪除學生資料
    $stmt1 = mysqli_prepare($link, "DELETE FROM ExternalAwardStudent WHERE teacher_id = ? AND name = ? AND date = ?");
    mysqli_stmt_bind_param($stmt1, 'iss', $teacher_id, $name, $date);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);

    // 再刪除主資料
    $stmt2 = mysqli_prepare($link, "DELETE FROM ExternalAward WHERE teacher_id = ? AND name = ? AND date = ?");
    mysqli_stmt_bind_param($stmt2, 'iss', $teacher_id, $name, $date);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);
}

header("Location: award_list.php");
exit;
?>
