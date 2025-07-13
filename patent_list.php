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
    <title>專利列表</title>
    <link rel="stylesheet" href="patent_list_style.css">
</head>
<body>
<div class = "container">
<h2>📄 我的專利</h2>
<form method="get">
    關鍵字搜尋：<input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>">
    <input type="submit" value="搜尋" class="btn">
</form>
<p><a href="patent_insert.php" class="btn">➕ 新增專利</a></p>

<table border="1" cellpadding="10">
    <tr>
        <th>標題</th>
        <th>類型</th>
        <th>專利號碼</th>
        <th>起始日</th>
        <th>結束日</th>
        <th>操作</th>
    </tr>
    <?php
    if ($keyword !== '') {
        $stmt = mysqli_prepare($link, "SELECT * FROM Patent WHERE teacher_id = ? AND (title LIKE ? OR number LIKE ?)");
        $kw = "%$keyword%";
        mysqli_stmt_bind_param($stmt, 'iss', $teacher_id, $kw, $kw);
    } else {
        $stmt = mysqli_prepare($link, "SELECT * FROM Patent WHERE teacher_id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $teacher_id);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['type']) . "</td>";
        echo "<td>" . htmlspecialchars($row['number']) . "</td>";
        echo "<td>" . htmlspecialchars($row['start_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['end_date']) . "</td>";
        echo "<td><a href='patent_update.php?number=" . urlencode($row['number']) . "'>編輯</a> | ";
        echo "<a href='patent_delete.php?number=" . urlencode($row['number']) . "' onclick='return confirm(\"確定要刪除此專利？\")'>刪除</a></td>";
        echo "</tr>";
    }
    mysqli_stmt_close($stmt);
    ?>
</table>
    <p><a href="index576.php" class="btn btn-outline">返回首頁</a></p>
</div>
</body>
</html>
