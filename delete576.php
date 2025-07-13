<?php
require_once 'phpdb.php';

$id = $_GET['id'] ?? 0;



$stmt = mysqli_prepare($link, "DELETE FROM Teacher WHERE teacher_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: select576.php");
    exit;
} else {
    $error = mysqli_error($link);
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head><meta charset="UTF-8"><title>刪除失敗</title></head>
<body>
<h2 style="color:red;">❌ 無法刪除該教師</h2>
<p>可能仍有資料關聯（如課表、計畫、論文等）。</p>
<p style="color:gray;">錯誤訊息：<?= htmlspecialchars($error) ?></p>
<p><a href="select576.php">🔙 返回教師列表</a></p>
</body>
</html>
