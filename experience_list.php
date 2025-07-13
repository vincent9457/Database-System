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
    <title>經歷列表</title>
    <link rel="stylesheet" href="experience_list_style.css">
</head>
<body>
<div class="container">
<h2>📘 經歷紀錄</h2>
<form method="get">
    關鍵字搜尋（單位或職稱）：<input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>">
    <input type="submit" value="搜尋" class="btn">
</form>
<p><a href="experience_insert.php" class="btn">➕ 新增經歷</a></p>

<table border="1" cellpadding="10">
    <tr>
        <th>類別</th><th>單位</th><th>職稱</th><th>學校</th><th>操作</th>
    </tr>
    <?php
    if ($keyword !== '') {
        $stmt = mysqli_prepare($link, "SELECT * FROM Experience WHERE teacher_id = ? AND (organization LIKE ? OR role LIKE ?)");
        $kw = "%$keyword%";
        mysqli_stmt_bind_param($stmt, 'iss', $teacher_id, $kw, $kw);
    } else {
        $stmt = mysqli_prepare($link, "SELECT * FROM Experience WHERE teacher_id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $teacher_id);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['category']) . "</td>";
        echo "<td>" . htmlspecialchars($row['organization']) . "</td>";
        echo "<td>" . htmlspecialchars($row['role']) . "</td>";
        echo "<td>" . htmlspecialchars($row['school']) . "</td>";

        // 修正編輯與刪除連結，加入 category 參數
        $category = urlencode($row['category']);
        $organization = urlencode($row['organization']);
        $role = urlencode($row['role']);

        echo "<td>
                <a href='experience_update.php?category={$category}&organization={$organization}&role={$role}'>編輯</a> | 
                <a href='experience_delete.php?category={$category}&organization={$organization}&role={$role}' onclick='return confirm(\"確定要刪除？\")'>刪除</a>
              </td>";
        echo "</tr>";
    }

    mysqli_stmt_close($stmt);
    ?>
</table>
<p><a href="index576.php" class="btn btn-outline">返回首頁</a></p>
</div>
</body>
</html>
