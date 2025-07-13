<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$original_date = $_GET['date'] ?? '';
$original_topic = $_GET['topic'] ?? '';

if (!$original_date || !$original_topic) {
    echo "<p style='color:red;'>參數錯誤</p><a href='speech_list.php'>返回</a>";
    exit;
}

// 查詢原始資料
$stmt = mysqli_prepare($link, "SELECT * FROM Speech WHERE teacher_id = ? AND date = ? AND topic = ?");
mysqli_stmt_bind_param($stmt, 'iss', $teacher_id, $original_date, $original_topic);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row) {
    echo "<p style='color:red;'>找不到此演講資料</p><a href='speech_list.php'>返回</a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_date = $_POST['date'];
    $new_topic = $_POST['topic'];
    $organizer = $_POST['organizer'];

    $stmt = mysqli_prepare($link, "
        UPDATE Speech SET date = ?, topic = ?, organizer = ?
        WHERE teacher_id = ? AND date = ? AND topic = ?
    ");
    mysqli_stmt_bind_param($stmt, 'sssiss', $new_date, $new_topic, $organizer, $teacher_id, $original_date, $original_topic);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: speech_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>編輯演講</title>
    <link rel="stylesheet" href="speech_update_style.css">
</head>
<body>
<div class="container">
<h2>✏️ 編輯演講資料</h2>
<form method="post">
    日期：<input type="date" name="date" value="<?= htmlspecialchars($row['date']) ?>" required><br><br>
    主題：<input type="text" name="topic" value="<?= htmlspecialchars($row['topic']) ?>" required><br><br>
    主辦單位：<input type="text" name="organizer" value="<?= htmlspecialchars($row['organizer']) ?>" required><br><br>
    <input type="submit" value="更新" class="btn">
</form>
<p><a href="speech_list.php" class="btn-outline">返回演講列表</a></p>
</div>
</body>
</html>
