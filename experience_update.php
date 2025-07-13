<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$original_category = $_GET['category'] ?? '';
$original_organization = $_GET['organization'] ?? '';
$original_role = $_GET['role'] ?? '';

// 檢查參數是否齊全
if (trim($original_category) === '' || trim($original_organization) === '' || trim($original_role) === '') {
    echo "<p style='color:red;'>缺少參數</p><a href='experience_list.php'>返回</a>";
    exit;
}

// 查詢原始資料
$stmt = mysqli_prepare($link, "SELECT * FROM Experience WHERE teacher_id=? AND category=? AND organization=? AND role=?");
mysqli_stmt_bind_param($stmt, 'isss', $teacher_id, $original_category, $original_organization, $original_role);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row) {
    echo "<p style='color:red;'>找不到該筆經歷資料</p><a href='experience_list.php'>返回</a>";
    exit;
}

// 表單送出處理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_category = trim($_POST['category']);
    $new_organization = trim($_POST['organization']);
    $new_role = trim($_POST['role']);
    $school = trim($_POST['school']);

    // 先刪除原始紀錄
    $del = mysqli_prepare($link, "DELETE FROM Experience WHERE teacher_id=? AND category=? AND organization=? AND role=?");
    mysqli_stmt_bind_param($del, 'isss', $teacher_id, $original_category, $original_organization, $original_role);
    mysqli_stmt_execute($del);
    mysqli_stmt_close($del);

    // 再新增更新後的紀錄
    $ins = mysqli_prepare($link, "INSERT INTO Experience (teacher_id, category, organization, role, school) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($ins, 'issss', $teacher_id, $new_category, $new_organization, $new_role, $school);
    mysqli_stmt_execute($ins);
    mysqli_stmt_close($ins);

    header("Location: experience_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>編輯經歷</title>
    <link rel="stylesheet" href="experience_update_style.css">
</head>
<body>
<div class="container">
<h2>✏️ 編輯經歷資料</h2>
<form method="post">
    類別：
    <select name="category" required>
        <option value="校內" <?= $row['category'] === '校內' ? 'selected' : '' ?>>校內</option>
        <option value="校外" <?= $row['category'] === '校外' ? 'selected' : '' ?>>校外</option>
    </select><br><br>

    任職單位：<input type="text" name="organization" value="<?= htmlspecialchars($row['organization']) ?>" required><br><br>
    職稱：<input type="text" name="role" value="<?= htmlspecialchars($row['role']) ?>" required><br><br>
    所屬學校：<input type="text" name="school" value="<?= htmlspecialchars($row['school']) ?>"><br><br>

    <input type="submit" value="更新" class="btn">
</form>
<p><a href="experience_list.php" class="btn-outline">返回經歷列表</a></p>
</div>
</body>
</html>
