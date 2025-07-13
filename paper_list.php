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
    <title>論文列表</title>
    <link rel="stylesheet" href="paper_list_style.css">

</head>
<body>
<div class = "container">
<h2>📚 論文紀錄</h2>
<form method="get">
    關鍵字搜尋（標題）：<input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>">
    <input type="submit" value="搜尋" class="btn">

</form>
<p><a href="paper_insert.php" class="btn">➕ 新增論文</a></p>

<table border="1" cellpadding="10">
    <tr>
        <th>論文標題</th><th>類別</th><th>出版日期</th><th>作者</th><th>操作</th>
    </tr>
    <?php
    if ($keyword !== '') {
        $stmt = mysqli_prepare($link, "SELECT * FROM Paper WHERE teacher_id = ? AND title LIKE ?");
        $kw = "%$keyword%";
        mysqli_stmt_bind_param($stmt, 'is', $teacher_id, $kw);
    } else {
        $stmt = mysqli_prepare($link, "SELECT * FROM Paper WHERE teacher_id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $teacher_id);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $paper_id = $row['paper_id'];
        $category = $row['category'];
        $publish_date = '';
        $authors = [];

        switch ($category) {
            case '專書論文':
                $res = mysqli_query($link, "SELECT publish_date FROM BookPaper WHERE paper_id = $paper_id");
                $res2 = mysqli_query($link, "SELECT author FROM BookPaperAuthor WHERE paper_id = $paper_id");
                break;
            case '會議論文':
                $res = mysqli_query($link, "SELECT conf_date AS publish_date FROM ConferencePaper WHERE paper_id = $paper_id");
                $res2 = mysqli_query($link, "SELECT author FROM ConferencePaperAuthor WHERE paper_id = $paper_id");
                break;
            case '專書和技術報告':
                $res = mysqli_query($link, "SELECT publish_date FROM TechReport WHERE paper_id = $paper_id");
                $res2 = mysqli_query($link, "SELECT author FROM TechReportAuthor WHERE paper_id = $paper_id");
                break;
            case '期刊論文':
                $res = mysqli_query($link, "SELECT publish_date FROM JournalPaper WHERE paper_id = $paper_id");
                $res2 = mysqli_query($link, "SELECT author FROM JournalPaperAuthor WHERE paper_id = $paper_id");
                break;
        }

        if ($res && mysqli_num_rows($res)) {
            $date_row = mysqli_fetch_assoc($res);
            $publish_date = $date_row['publish_date'] ?? '';
        }
        while ($a = mysqli_fetch_assoc($res2)) {
            $authors[] = $a['author'];
        }

        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td>" . htmlspecialchars($category) . "</td>";
        echo "<td>" . htmlspecialchars($publish_date) . "</td>";
        echo "<td>" . htmlspecialchars(implode(', ', $authors)) . "</td>";
        echo "<td><a href='paper_update.php?paper_id=$paper_id'>編輯</a> | ";
        echo "<a href='paper_delete.php?paper_id=$paper_id' onclick='return confirm(\"確定要刪除？\")'>刪除</a></td>";
        echo "</tr>";
    }
    mysqli_stmt_close($stmt);
    ?>
</table>
<p><a href="index576.php" class="btn btn-outline">返回首頁</a></p>
</div>
</body>
</html>
