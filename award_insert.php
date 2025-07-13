<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$type = $_GET['type'] ?? 'internal'; // default to internal

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $organizer = $_POST['organizer'];
    $date = $_POST['date'];

    if ($_POST['type'] === 'internal') {
        $award = $_POST['award'];
        $stmt = mysqli_prepare($link, "INSERT INTO InternalAward (teacher_id, name, award, organizer, award_date) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'issss', $teacher_id, $name, $award, $organizer, $date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $result = $_POST['result'];
        $students = array_filter(array_map('trim', explode(',', $_POST['students'])));

        $stmt = mysqli_prepare($link, "INSERT INTO ExternalAward (teacher_id, name, date, organizer, result) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'issss', $teacher_id, $name, $date, $organizer, $result);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        foreach ($students as $student) {
            $stmt2 = mysqli_prepare($link, "INSERT INTO ExternalAwardStudent (teacher_id, name, date, student) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt2, 'isss', $teacher_id, $name, $date, $student);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt2);
        }
    }

    header("Location: award_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>新增獎項</title>
    <link rel="stylesheet" href="award_insert_style.css">
    <script>
        function toggleFields() {
            var type = document.querySelector('input[name="type"]:checked').value;
            var internalFields = document.getElementById('internal_fields');
            var externalFields = document.getElementById('external_fields');
            var awardInput = document.querySelector('input[name="award"]');

            if (type === 'internal') {
                internalFields.style.display = 'block';
                externalFields.style.display = 'none';
                awardInput.setAttribute('required', 'required');
            } else {
                internalFields.style.display = 'none';
                externalFields.style.display = 'block';
                awardInput.removeAttribute('required');
            }
        }
        window.onload = toggleFields;
        
        function checkDate() {
        var dateInput = document.querySelector('input[name="date"]');
        var inputDate = dateInput.value;
        if (!inputDate) return true; // 沒填交給 HTML required 檢查

        // 取得今天日期字串 yyyy-mm-dd
        var today = new Date();
        var yyyy = today.getFullYear();
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var dd = String(today.getDate()).padStart(2, '0');
        var todayStr = yyyy + '-' + mm + '-' + dd;

        if (inputDate > todayStr) {
            alert("❌ 得獎/比賽日期不可大於今天！");
            return false;
        }
        return true;
    }
    </script>
</head>
<body>
<div class="container">
<h2>➕ 新增獎項</h2>
<form method="post" onsubmit="return checkDate();">
    類型：
    <label><input type="radio" name="type" value="internal" <?= $type === 'internal' ? 'checked' : '' ?> onclick="toggleFields()">校內</label>
    <label><input type="radio" name="type" value="external" <?= $type === 'external' ? 'checked' : '' ?> onclick="toggleFields()">校外</label>
    <br><br>

    獎項名稱：<input type="text" name="name" required><br><br>
    主辦單位：<input type="text" name="organizer" required><br><br>
    日期（得獎或比賽日期）：<input type="date" name="date" required><br><br>

    <div id="internal_fields">
        得獎項目：<input type="text" name="award" required><br><br>
    </div>

    <div id="external_fields" style="display:none;">
        比賽結果：<input type="text" name="result"><br><br>
        學生名單（逗號分隔）：<input type="text" name="students"><br><br>
    </div>

    <input type="submit" value="確認送出" class="btn">
</form>
<p><a href="award_list.php" class="btn-outline">返回獎項列表</a></p>
</div>
</body>
</html>