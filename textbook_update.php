<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$textbook_id = $_GET['textbook_id'] ?? 0;

// 確認教材是否屬於該老師
$stmt = mysqli_prepare($link, "SELECT * FROM Textbook WHERE textbook_id = ? AND teacher_id = ?");
mysqli_stmt_bind_param($stmt, 'ii', $textbook_id, $teacher_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$textbook = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$textbook) {
    echo "<p style='color:red;'>找不到此教材或無權限</p><a href='textbook_list.php'>返回</a>";
    exit;
}

// 查詢作者資料
$authors = [];
$a_stmt = mysqli_prepare($link, "SELECT author FROM TextbookAuthor WHERE textbook_id = ?");
mysqli_stmt_bind_param($a_stmt, 'i', $textbook_id);
mysqli_stmt_execute($a_stmt);
$a_result = mysqli_stmt_get_result($a_stmt);
while ($row = mysqli_fetch_assoc($a_result)) {
    $authors[] = $row['author'];
}
mysqli_stmt_close($a_stmt);
$author_str = implode(', ', $authors);

// 表單送出後處理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $publisher = trim($_POST['publisher']);
    $authors_input = trim($_POST['authors']);
    $author_array = array_filter(array_map('trim', explode(',', $authors_input)));

    // 更新教材主資料
    $stmt = mysqli_prepare($link, "UPDATE Textbook SET name = ?, publisher = ? WHERE textbook_id = ?");
    mysqli_stmt_bind_param($stmt, 'ssi', $name, $publisher, $textbook_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // 刪除原有作者資料（用 prepared statement）
    $del_stmt = mysqli_prepare($link, "DELETE FROM TextbookAuthor WHERE textbook_id = ?");
    mysqli_stmt_bind_param($del_stmt, 'i', $textbook_id);
    mysqli_stmt_execute($del_stmt);
    mysqli_stmt_close($del_stmt);

    // 新增作者資料
    foreach ($author_array as $author) {
        $stmt2 = mysqli_prepare($link, "INSERT INTO TextbookAuthor (textbook_id, author) VALUES (?, ?)");
        if ($stmt2) {
            mysqli_stmt_bind_param($stmt2, 'is', $textbook_id, $author);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt2);
        }
    }

    header("Location: textbook_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>編輯教材</title>
    <link rel="stylesheet" href="textbook_update_style.css">
</head>
<body>
<div class="container">
<h2>✏️ 編輯教材資料</h2>
<form method="post">
    教材名稱：<input type="text" name="name" value="<?= htmlspecialchars($textbook['name']) ?>" required><br><br>
    出版社：<input type="text" name="publisher" value="<?= htmlspecialchars($textbook['publisher']) ?>" required><br><br>
    作者（用逗號分隔）：<input type="text" name="authors" value="<?= htmlspecialchars($author_str) ?>" required><br><br>
    <input type="submit" value="更新" class="btn">
</form>
<p><a href="textbook_list.php" class="btn-outline">返回教材作品列表</a></p>
</div>
</body>
</html>
