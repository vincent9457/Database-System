<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$keyword = $_GET['q'] ?? '';
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>演講列表</title>
    <link rel="stylesheet" href="speech_list_style.css">
</head>
<body>
<div class="container">
<h2>🗣️ 校內外演講</h2>
<form method="get">
    關鍵字搜尋（主題或主辦單位）：<input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>">
    <input type="submit" value="搜尋" class="btn">
</form>
<p><a href="speech_insert.php" class="btn">➕ 新增演講</a></p>

<table border="1" cellpadding="10">
    <tr>
        <th>日期</th><th>主題</th><th>主辦單位</th><th>操作</th>
    </tr>
    <?php
    if ($keyword !== '') {
        $stmt = mysqli_prepare($link, "SELECT * FROM Speech WHERE teacher_id = ? AND (topic LIKE ? OR organizer LIKE ?)");
        $kw = "%$keyword%";
        mysqli_stmt_bind_param($stmt, 'iss', $teacher_id, $kw, $kw);
    } else {
        $stmt = mysqli_prepare($link, "SELECT * FROM Speech WHERE teacher_id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $teacher_id);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['topic']) . "</td>";
        echo "<td>" . htmlspecialchars($row['organizer']) . "</td>";
        echo "<td><a href='speech_update.php?date=" . $row['date'] . "&topic=" . urlencode($row['topic']) . "'>編輯</a> | ";
        echo "<a href='speech_delete.php?date=" . $row['date'] . "&topic=" . urlencode($row['topic']) . "' onclick='return confirm(\"確定要刪除？\")'>刪除</a></td>";
        echo "</tr>";
    }
    mysqli_stmt_close($stmt);
    ?>
</table>
<p><a href="index576.php" class="btn btn-outline">返回首頁</a></p>
</div>
</body>
</html>
