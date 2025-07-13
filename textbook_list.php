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
    <title>教材作品列表</title>
    <link rel="stylesheet" href="textbook_list_style.css">
</head>
<body>
<div class="container">
<h2>📘 教材作品</h2>
<form method="get">
    關鍵字搜尋（教材名稱或出版社）：<input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>">
    <input type="submit" value="搜尋" class="btn">
</form>
<p><a href="textbook_insert.php" class="btn">➕ 新增教材</a></p>

<table border="1" cellpadding="10">
    <tr>
        <th>教材名稱</th><th>出版社</th><th>作者</th><th>操作</th>
    </tr>
    <?php
    if ($keyword !== '') {
        $stmt = mysqli_prepare($link, "SELECT * FROM Textbook WHERE teacher_id = ? AND (name LIKE ? OR publisher LIKE ?)");
        $kw = "%$keyword%";
        mysqli_stmt_bind_param($stmt, 'iss', $teacher_id, $kw, $kw);
    } else {
        $stmt = mysqli_prepare($link, "SELECT * FROM Textbook WHERE teacher_id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $teacher_id);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['publisher']) . "</td>";

        // 正確從 TextbookAuthor 取出對應作者
        $stmt2 = mysqli_prepare($link, "SELECT author FROM TextbookAuthor WHERE textbook_id = ?");
        mysqli_stmt_bind_param($stmt2, 'i', $row['textbook_id']);
        mysqli_stmt_execute($stmt2);
        $res2 = mysqli_stmt_get_result($stmt2);
        $authors = [];
        while ($a = mysqli_fetch_assoc($res2)) {
            $authors[] = $a['author'];
        }
        mysqli_stmt_close($stmt2);

        echo "<td>" . htmlspecialchars(implode(', ', $authors)) . "</td>";

        // 加入 textbook_id 作為參數
        echo "<td>
                <a href='textbook_update.php?textbook_id=" . $row['textbook_id'] . "'>編輯</a> |
                <a href='textbook_delete.php?textbook_id=" . $row['textbook_id'] . "' onclick='return confirm(\"確定要刪除？\")'>刪除</a>
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
