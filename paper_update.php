<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$paper_id = $_GET['paper_id'] ?? 0;
$error = "";

$sql = "SELECT * FROM Paper WHERE paper_id = ? AND teacher_id = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $paper_id, $teacher_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$paper = mysqli_fetch_assoc($result);

if (!$paper) {
    echo "<p style='color:red;'>⚠️ 找不到論文或權限不足</p><a href='paper_list.php'>返回</a>";
    exit;
}

$category = $paper['category'];
$authors = [];
switch ($category) {
    case '專書論文':
        $detail = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM BookPaper WHERE paper_id = $paper_id"));
        $author_result = mysqli_query($link, "SELECT author FROM BookPaperAuthor WHERE paper_id = $paper_id");
        break;
    case '會議論文':
        $detail = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM ConferencePaper WHERE paper_id = $paper_id"));
        $author_result = mysqli_query($link, "SELECT author FROM ConferencePaperAuthor WHERE paper_id = $paper_id");
        break;
    case '專書和技術報告':
        $detail = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM TechReport WHERE paper_id = $paper_id"));
        $author_result = mysqli_query($link, "SELECT author FROM TechReportAuthor WHERE paper_id = $paper_id");
        break;
    case '期刊論文':
        $detail = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM JournalPaper WHERE paper_id = $paper_id"));
        $author_result = mysqli_query($link, "SELECT author FROM JournalPaperAuthor WHERE paper_id = $paper_id");
        break;
}
while ($row = mysqli_fetch_assoc($author_result)) {
    $authors[] = $row['author'];
}
$author_input = implode(', ', $authors);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $authors_post = array_filter(array_map('trim', explode(',', $_POST['authors'])));

    $stmt = mysqli_prepare($link, "UPDATE Paper SET title = ? WHERE paper_id = ?");
    mysqli_stmt_bind_param($stmt, 'si', $title, $paper_id);
    mysqli_stmt_execute($stmt);

    switch ($category) {
        case '專書論文':
            $sql = "UPDATE BookPaper SET name=?, pages=?, publish_date=?, publisher=? WHERE paper_id=?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, 'ssssi', $_POST['name'], $_POST['pages'], $_POST['publish_date'], $_POST['publisher'], $paper_id);
            mysqli_stmt_execute($stmt);
            mysqli_query($link, "DELETE FROM BookPaperAuthor WHERE paper_id=$paper_id");
            foreach ($authors_post as $a) {
                $stmt2 = mysqli_prepare($link, "INSERT INTO BookPaperAuthor (paper_id, author) VALUES (?, ?)");
                mysqli_stmt_bind_param($stmt2, 'is', $paper_id, $a);
                mysqli_stmt_execute($stmt2);
            }
            break;
        case '會議論文':
            $sql = "UPDATE ConferencePaper SET conf_date=?, school=?, conference_name=? WHERE paper_id=?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, 'sssi', $_POST['conf_date'], $_POST['school'], $_POST['conference_name'], $paper_id);
            mysqli_stmt_execute($stmt);
            mysqli_query($link, "DELETE FROM ConferencePaperAuthor WHERE paper_id=$paper_id");
            foreach ($authors_post as $a) {
                $stmt2 = mysqli_prepare($link, "INSERT INTO ConferencePaperAuthor (paper_id, author) VALUES (?, ?)");
                mysqli_stmt_bind_param($stmt2, 'is', $paper_id, $a);
                mysqli_stmt_execute($stmt2);
            }
            break;
        case '專書和技術報告':
            $sql = "UPDATE TechReport SET publish_date=?, pages=?, publisher=?, publish_place=? WHERE paper_id=?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, 'ssssi', $_POST['publish_date'], $_POST['pages'], $_POST['publisher'], $_POST['publish_place'], $paper_id);
            mysqli_stmt_execute($stmt);
            mysqli_query($link, "DELETE FROM TechReportAuthor WHERE paper_id=$paper_id");
            foreach ($authors_post as $a) {
                $stmt2 = mysqli_prepare($link, "INSERT INTO TechReportAuthor (paper_id, author) VALUES (?, ?)");
                mysqli_stmt_bind_param($stmt2, 'is', $paper_id, $a);
                mysqli_stmt_execute($stmt2);
            }
            break;
        case '期刊論文':
            $sql = "UPDATE JournalPaper SET publish_date=?, pages=?, volume=? WHERE paper_id=?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, 'sssi', $_POST['publish_date'], $_POST['pages'], $_POST['volume'], $paper_id);
            mysqli_stmt_execute($stmt);
            mysqli_query($link, "DELETE FROM JournalPaperAuthor WHERE paper_id=$paper_id");
            foreach ($authors_post as $a) {
                $stmt2 = mysqli_prepare($link, "INSERT INTO JournalPaperAuthor (paper_id, author) VALUES (?, ?)");
                mysqli_stmt_bind_param($stmt2, 'is', $paper_id, $a);
                mysqli_stmt_execute($stmt2);
            }
            break;
    }

    header("Location: paper_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head><meta charset="UTF-8">
<title>編輯論文</title>
<link rel="stylesheet" href="paper_update_style.css">
<script>
function checkDatesNotFuture() {
    // 今天 yyyy-mm-dd
    var today = new Date();
    var yyyy = today.getFullYear();
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var dd = String(today.getDate()).padStart(2, '0');
    var todayStr = yyyy + '-' + mm + '-' + dd;

    // 所有表單裡的日期欄位（會議日期、出版日期...）
    var dateFields = [
        'publish_date',
        'conf_date'
    ];
    for (var i = 0; i < dateFields.length; i++) {
        var inputs = document.getElementsByName(dateFields[i]);
        for (var j = 0; j < inputs.length; j++) {
            var v = inputs[j].value;
            if (v && v > todayStr) {
                alert("❌ 論文出版/會議日期不可大於今天！");
                return false;
            }
        }
    }
    return true;
}
</script>
</head>
<body>
<div class="container">
<h2>✏️ 編輯論文</h2>
<form method="post" onsubmit="return checkDatesNotFuture();">
  論文標題：<input type="text" name="title" value="<?= htmlspecialchars($paper['title']) ?>" required><br><br>

  <?php if ($category == '專書論文'): ?>
    書名：<input type="text" name="name" value="<?= $detail['name'] ?>"><br>
    頁數：<input type="text" name="pages" value="<?= $detail['pages'] ?>"><br>
    出版日期：<input type="date" name="publish_date" value="<?= $detail['publish_date'] ?>"><br>
    出版社：<input type="text" name="publisher" value="<?= $detail['publisher'] ?>"><br>

  <?php elseif ($category == '會議論文'): ?>
    會議日期：<input type="date" name="conf_date" value="<?= $detail['conf_date'] ?>"><br>
    主辦單位：<input type="text" name="school" value="<?= $detail['school'] ?>"><br>
    會議名稱：<input type="text" name="conference_name" value="<?= $detail['conference_name'] ?>"><br>

  <?php elseif ($category == '專書和技術報告'): ?>
    出版日期：<input type="date" name="publish_date" value="<?= $detail['publish_date'] ?>"><br>
    頁數：<input type="text" name="pages" value="<?= $detail['pages'] ?>"><br>
    出版社：<input type="text" name="publisher" value="<?= $detail['publisher'] ?>"><br>
    出版地點：<input type="text" name="publish_place" value="<?= $detail['publish_place'] ?>"><br>

  <?php elseif ($category == '期刊論文'): ?>
    出版日期：<input type="date" name="publish_date" value="<?= $detail['publish_date'] ?>"><br>
    頁數：<input type="text" name="pages" value="<?= $detail['pages'] ?>"><br>
    卷期：<input type="text" name="volume" value="<?= $detail['volume'] ?>"><br>
  <?php endif; ?>

  <h4>作者（用逗號分隔）：</h4>
  <input type="text" name="authors" value="<?= htmlspecialchars($author_input) ?>"><br><br>

  <input type="submit" value="更新" class="btn">
</form>
<p><a href="paper_list.php" class="btn-outline">返回論文列表</a></p>
</div>
</body>
</html>
