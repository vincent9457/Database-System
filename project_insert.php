<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $role = $_POST['role'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $nstc_code = $_POST['nstc_code'] ?? null;

    // 插入 Project 主表
    $stmt = mysqli_prepare($link, "INSERT INTO Project (name, category, teacher_id) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssi', $name, $category, $teacher_id);
    mysqli_stmt_execute($stmt);
    $project_id = mysqli_insert_id($link);
    mysqli_stmt_close($stmt);

    // 插入對應子表
    if ($category === '國科會計畫') {
        $stmt = mysqli_prepare($link, "INSERT INTO NSTCProject (project_id, role, nstc_code, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'issss', $project_id, $role, $nstc_code, $start_date, $end_date);
    } else {
        $stmt = mysqli_prepare($link, "INSERT INTO IndustryProject (project_id, role, start_date, end_date) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'isss', $project_id, $role, $start_date, $end_date);
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: project_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>新增計畫</title>
    <link rel="stylesheet" href="project_insert_style.css">
    <script>
        function toggleFields() {
            var category = document.getElementById("category").value;
            document.getElementById("nstc_fields").style.display = (category === "國科會計畫") ? "block" : "none";
        }

        function checkProjectDates() {
            var start = document.querySelector('input[name="start_date"]').value;
            var end = document.querySelector('input[name="end_date"]').value;
            if (start && end && end < start) {
                alert("❌ 結束日期不可早於起始日期！");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
<div class="container">
<h2>➕ 新增計畫</h2>
<form method="post" onsubmit="return checkProjectDates();">
    計畫名稱：<input type="text" name="name" required><br><br>

    類別：
    <select name="category" id="category" onchange="toggleFields()" required>
        <option value="">-- 請選擇 --</option>
        <option value="國科會計畫">國科會計畫</option>
        <option value="產學合作">產學合作</option>
    </select><br><br>

    擔任角色：<input type="text" name="role" required><br><br>

    起始日期：<input type="date" name="start_date" required><br><br>
    結束日期：<input type="date" name="end_date" required><br><br>

    <div id="nstc_fields" style="display:none;">
        國科會代碼：<input type="text" name="nstc_code"><br><br>
    </div>

    <input type="submit" value="確認送出" class="btn">
</form>
<p><a href="project_list.php" class="btn-outline">返回計畫列表</a></p>
</div>
</body>
</html>
