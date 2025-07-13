<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$paper_id = $_GET['paper_id'] ?? 0;

// 驗證是否有權限刪除
$sql = "SELECT category FROM Paper WHERE paper_id = ? AND teacher_id = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $paper_id, $teacher_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<p style='color:red;'>⚠️ 無此論文或權限不足</p><a href='paper_list.php'>返回</a>";
    exit;
}

$category = $row['category'];

// 刪除子表與作者表
switch ($category) {
    case '專書論文':
        mysqli_query($link, "DELETE FROM BookPaperAuthor WHERE paper_id = $paper_id");
        mysqli_query($link, "DELETE FROM BookPaper WHERE paper_id = $paper_id");
        break;
    case '會議論文':
        mysqli_query($link, "DELETE FROM ConferencePaperAuthor WHERE paper_id = $paper_id");
        mysqli_query($link, "DELETE FROM ConferencePaper WHERE paper_id = $paper_id");
        break;
    case '專書和技術報告':
        mysqli_query($link, "DELETE FROM TechReportAuthor WHERE paper_id = $paper_id");
        mysqli_query($link, "DELETE FROM TechReport WHERE paper_id = $paper_id");
        break;
    case '期刊論文':
        mysqli_query($link, "DELETE FROM JournalPaperAuthor WHERE paper_id = $paper_id");
        mysqli_query($link, "DELETE FROM JournalPaper WHERE paper_id = $paper_id");
        break;
}

// 刪除主表
$stmt = mysqli_prepare($link, "DELETE FROM Paper WHERE paper_id = ? AND teacher_id = ?");
mysqli_stmt_bind_param($stmt, 'ii', $paper_id, $teacher_id);
mysqli_stmt_execute($stmt);

header("Location: paper_list.php");
exit;
?>
