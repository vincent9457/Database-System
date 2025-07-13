<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$type = $_GET['type'] ?? '';
$name = $_GET['name'] ?? '';
$date = $_GET['date'] ?? '';

if (!in_array($type, ['internal', 'external'])) {
    echo "<p style='color:red;'>錯誤的類型參數</p><a href='award_list.php'>返回</a>";
    exit;
}

if ($type === 'internal') {
    $stmt = mysqli_prepare($link, "SELECT * FROM InternalAward WHERE teacher_id=? AND name=? AND award_date=?");
} else {
    $stmt = mysqli_prepare($link, "SELECT * FROM ExternalAward WHERE teacher_id=? AND name=? AND date=?");
}
mysqli_stmt_bind_param($stmt, 'iss', $teacher_id, $name, $date);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row) {
    echo "<p style='color:red;'>找不到該筆資料</p><a href='award_list.php'>返回</a>";
    exit;
}

$students_str = '';
if ($type === 'external') {
    $stmt2 = mysqli_prepare($link, "SELECT student FROM ExternalAwardStudent WHERE teacher_id=? AND name=? AND date=?");
    mysqli_stmt_bind_param($stmt2, 'iss', $teacher_id, $name, $date);
    mysqli_stmt_execute($stmt2);
    $res2 = mysqli_stmt_get_result($stmt2);
    $students = [];
    while ($stu = mysqli_fetch_assoc($res2)) {
        $students[] = $stu['student'];
    }
    $students_str = implode(', ', $students);
    mysqli_stmt_close($stmt2);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = $_POST['name'];
    $new_date = $_POST['date'];
    $organizer = $_POST['organizer'];

    if ($type === 'internal') {
        $award = $_POST['award'];
        $stmt = mysqli_prepare($link, "UPDATE InternalAward SET name=?, award=?, organizer=?, award_date=? WHERE teacher_id=? AND name=? AND award_date=?");
        mysqli_stmt_bind_param($stmt, 'ssssiss', $new_name, $award, $organizer, $new_date, $teacher_id, $name, $date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $result_text = $_POST['result'];
        $students_input = $_POST['students'];
        $student_array = array_filter(array_map('trim', explode(',', $students_input)));

        // 刪除舊資料
        $stmt1 = mysqli_prepare($link, "DELETE FROM ExternalAwardStudent WHERE teacher_id=? AND name=? AND date=?");
        mysqli_stmt_bind_param($stmt1, 'iss', $teacher_id, $name, $date);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_close($stmt1);

        $stmt2 = mysqli_prepare($link, "DELETE FROM ExternalAward WHERE teacher_id=? AND name=? AND date=?");
        mysqli_stmt_bind_param($stmt2, 'iss', $teacher_id, $name, $date);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);

        // 新增新資料
        $stmt3 = mysqli_prepare($link, "INSERT INTO ExternalAward (teacher_id, name, date, organizer, result) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt3, 'issss', $teacher_id, $new_name, $new_date, $organizer, $result_text);
        mysqli_stmt_execute($stmt3);
        mysqli_stmt_close($stmt3);

        foreach ($student_array as $student) {
            $stmt4 = mysqli_prepare($link, "INSERT INTO ExternalAwardStudent (teacher_id, name, date, student) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt4, 'isss', $teacher_id, $new_name, $new_date, $student);
            mysqli_stmt_execute($stmt4);
            mysqli_stmt_close($stmt4);
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
    <title>編輯獎項</title>
    <link rel="stylesheet" href="award_update_style.css">
    <script>
    function checkDate() {
        var dateInput = document.querySelector('input[name="date"]');
        var inputDate = dateInput.value;
        if (!inputDate) return true;

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
<h2>✏️ 編輯<?= $type === 'internal' ? '校內' : '校外' ?>獎項</h2>
<form method="post" onsubmit="return checkDate();">
    獎項名稱：<input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required><br><br>
    主辦單位：<input type="text" name="organizer" value="<?= htmlspecialchars($row['organizer']) ?>" required><br><br>
    日期（得獎或比賽日期）：<input type="date" name="date" value="<?= htmlspecialchars($row[$type === 'internal' ? 'award_date' : 'date']) ?>" required><br><br>

    <?php if ($type === 'internal'): ?>
        得獎項目：<input type="text" name="award" value="<?= htmlspecialchars($row['award']) ?>" required><br><br>
    <?php else: ?>
        比賽結果：<input type="text" name="result" value="<?= htmlspecialchars($row['result']) ?>"><br><br>
        學生名單（逗號分隔）：<input type="text" name="students" value="<?= htmlspecialchars($students_str) ?>"><br><br>
    <?php endif; ?>

    <input type="submit" value="更新" class="btn">
</form>
<p><a href="award_list.php" class="btn-outline">返回獎項列表</a></p>
</div>
</body>
</html>
