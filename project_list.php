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
    <title>計畫列表</title>
    <link rel="stylesheet" href="project_list_style.css">
</head>
<body>
<div class = "container">
<h2>📁 我的研究計畫</h2>
<form method="get">
    關鍵字搜尋（名稱）：<input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>">
    <input type="submit" value="搜尋" class="btn">
</form>
<p><a href="project_insert.php" class="btn">➕ 新增計畫</a></p>

<table border="1" cellpadding="10">
    <tr>
        <th>計畫名稱</th><th>類別</th><th>角色</th><th>起始日</th><th>結束日</th><th>其他資訊</th><th>操作</th>
    </tr>
    <?php
    if ($keyword !== '') {
        $stmt = mysqli_prepare($link, "SELECT * FROM Project WHERE teacher_id = ? AND name LIKE ?");
        $kw = "%$keyword%";
        mysqli_stmt_bind_param($stmt, 'is', $teacher_id, $kw);
    } else {
        $stmt = mysqli_prepare($link, "SELECT * FROM Project WHERE teacher_id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $teacher_id);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $project_id = $row['project_id'];
        $name = $row['name'];
        $category = $row['category'];
        $role = '';
        $start = '';
        $end = '';
        $extra = '';

        if ($category === '國科會計畫') {
            $res = mysqli_query($link, "SELECT * FROM NSTCProject WHERE project_id = $project_id");
            if ($r = mysqli_fetch_assoc($res)) {
                $role = $r['role'];
                $start = $r['start_date'];
                $end = $r['end_date'];
                $extra = '代碼：' . $r['nstc_code'];
            }
        } elseif ($category === '產學合作') {
            $res = mysqli_query($link, "SELECT * FROM IndustryProject WHERE project_id = $project_id");
            if ($r = mysqli_fetch_assoc($res)) {
                $role = $r['role'];
                $start = $r['start_date'];
                $end = $r['end_date'];
                $extra = '';
            }
        }

        echo "<tr>";
        echo "<td>" . htmlspecialchars($name) . "</td>";
        echo "<td>" . htmlspecialchars($category) . "</td>";
        echo "<td>" . htmlspecialchars($role) . "</td>";
        echo "<td>" . htmlspecialchars($start) . "</td>";
        echo "<td>" . htmlspecialchars($end) . "</td>";
        echo "<td>" . htmlspecialchars($extra) . "</td>";
        echo "<td><a href='project_update.php?project_id=$project_id'>編輯</a> | ";
        echo "<a href='project_delete.php?project_id=$project_id' onclick='return confirm(\"確定要刪除？\")'>刪除</a></td>";
        echo "</tr>";
    }
    mysqli_stmt_close($stmt);
    ?>
</table>
<p><a href="index576.php" class="btn btn-outline">返回首頁</a></p>
</div>
</body>
</html>
