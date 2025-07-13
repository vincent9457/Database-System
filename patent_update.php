<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$number = $_GET['number'] ?? '';

$stmt = mysqli_prepare($link, "SELECT * FROM Patent WHERE teacher_id = ? AND number = ?");
mysqli_stmt_bind_param($stmt, 'is', $teacher_id, $number);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$patent = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$patent) {
    echo "<p style='color:red;'>找不到資料</p><a href='patent_list.php'>返回</a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $type = $_POST['type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $stmt = mysqli_prepare($link, "UPDATE Patent SET title = ?, type = ?, start_date = ?, end_date = ? WHERE teacher_id = ? AND number = ?");
    mysqli_stmt_bind_param($stmt, 'ssssis', $title, $type, $start_date, $end_date, $teacher_id, $number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: patent_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>編輯專利</title>
    <link rel="stylesheet" href="patent_update_style.css">
    <script>
    function checkPatentDate() {
        var start = document.querySelector('input[name="start_date"]').value;
        var end = document.querySelector('input[name="end_date"]').value;
        if (start && end && end < start) {
            alert("❌ 結束日不可早於起始日！");
            return false;
        }
        return true;
    }
    </script>
</head>
<body>
<div class="container">
<h2>✏️ 編輯專利</h2>
<form method="post" onsubmit="return checkPatentDate();">
    標題：<input type="text" name="title" value="<?= htmlspecialchars($patent['title']) ?>" required><br><br>
    類型：<input type="text" name="type" value="<?= htmlspecialchars($patent['type']) ?>" required><br><br>
    專利號碼：<?= htmlspecialchars($patent['number']) ?><br><br>
    起始日：<input type="date" name="start_date" value="<?= htmlspecialchars($patent['start_date']) ?>"><br><br>
    結束日：<input type="date" name="end_date" value="<?= htmlspecialchars($patent['end_date']) ?>"><br><br>
    <input type="submit" value="更新" class="btn">
</form>
<p><a href="patent_list.php" class="btn-outline">返回專利列表</a></p>
</div>
</body>
</html>
