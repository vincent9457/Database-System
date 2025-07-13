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
    <title>獎項列表</title>
    <link rel="stylesheet" href="award_list_style.css">
</head>
<body>
<div class="container">
<form method="get">
    關鍵字搜尋（名稱或主辦單位）：<input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>">
<input type="submit" value="搜尋" class="btn">
</form>
<p><a href="award_insert.php" class="btn">➕ 新增獎項</a></p>
<h2>🏆 校內獎項</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>名稱</th><th>項目</th><th>主辦單位</th><th>日期</th><th>操作</th>
    </tr>
    <?php
    if ($keyword !== '') {
        $stmt = mysqli_prepare($link, "SELECT * FROM InternalAward WHERE teacher_id = ? AND (name LIKE ? OR organizer LIKE ?)");
        $kw = "%$keyword%";
        mysqli_stmt_bind_param($stmt, 'iss', $teacher_id, $kw, $kw);
    } else {
        $stmt = mysqli_prepare($link, "SELECT * FROM InternalAward WHERE teacher_id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $teacher_id);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['award']) . "</td>";
        echo "<td>" . htmlspecialchars($row['organizer']) . "</td>";
        echo "<td>" . htmlspecialchars($row['award_date']) . "</td>";
        echo "<td><a href='award_update.php?type=internal&name=" . urlencode($row['name']) . "&date=" . $row['award_date'] . "'>編輯</a> | ";
        echo "<a href='award_delete.php?type=internal&name=" . urlencode($row['name']) . "&date=" . $row['award_date'] . "' onclick='return confirm(\"確定要刪除？\")'>刪除</a></td>";
        echo "</tr>";
    }
    mysqli_stmt_close($stmt);
    ?>
</table>

<h2>🏅 校外獎項</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>名稱</th><th>主辦單位</th><th>結果</th><th>日期</th><th>學生</th><th>操作</th>
    </tr>
    <?php
    if ($keyword !== '') {
        $stmt = mysqli_prepare($link, "SELECT * FROM ExternalAward WHERE teacher_id = ? AND (name LIKE ? OR organizer LIKE ?)");
        $kw = "%$keyword%";
        mysqli_stmt_bind_param($stmt, 'iss', $teacher_id, $kw, $kw);
    } else {
        $stmt = mysqli_prepare($link, "SELECT * FROM ExternalAward WHERE teacher_id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $teacher_id);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['organizer']) . "</td>";
        echo "<td>" . htmlspecialchars($row['result']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date']) . "</td>";

        $stmt2 = mysqli_prepare($link, "SELECT student FROM ExternalAwardStudent WHERE teacher_id = ? AND name = ? AND date = ?");
        mysqli_stmt_bind_param($stmt2, 'iss', $teacher_id, $row['name'], $row['date']);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $students = [];
        while ($stu = mysqli_fetch_assoc($result2)) {
            $students[] = $stu['student'];
        }
        mysqli_stmt_close($stmt2);

        echo "<td>" . htmlspecialchars(implode(', ', $students)) . "</td>";
        echo "<td><a href='award_update.php?type=external&name=" . urlencode($row['name']) . "&date=" . $row['date'] . "'>編輯</a> | ";
        echo "<a href='award_delete.php?type=external&name=" . urlencode($row['name']) . "&date=" . $row['date'] . "' onclick='return confirm(\"確定要刪除？\")'>刪除</a></td>";
        echo "</tr>";
    }
    mysqli_stmt_close($stmt);
    ?>
</table>

<p><a href="index576.php" class="btn btn-outline">返回首頁</a></p>
</div>
</body>
</html>
