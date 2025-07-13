<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$project_id = $_GET['project_id'] ?? 0;

// 驗證擁有此計畫
$sql = "SELECT * FROM Project WHERE project_id = ? AND teacher_id = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $project_id, $teacher_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$project = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$project) {
    echo "<p style='color:red;'>⚠️ 無權限或找不到此計畫</p><a href='project_list.php'>返回</a>";
    exit;
}

$category = $project['category'];
$role = $start_date = $end_date = $nstc_code = "";

// 抓子表資料
if ($category === '國科會計畫') {
    $r = mysqli_query($link, "SELECT * FROM NSTCProject WHERE project_id = $project_id");
    if ($row = mysqli_fetch_assoc($r)) {
        $role = $row['role'];
        $nstc_code = $row['nstc_code'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
    }
} elseif ($category === '產學合作') {
    $r = mysqli_query($link, "SELECT * FROM IndustryProject WHERE project_id = $project_id");
    if ($row = mysqli_fetch_assoc($r)) {
        $role = $row['role'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $nstc_code = $_POST['nstc_code'] ?? null;

    // 更新主表
    $stmt = mysqli_prepare($link, "UPDATE Project SET name = ? WHERE project_id = ?");
    mysqli_stmt_bind_param($stmt, 'si', $name, $project_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // 更新子表
    if ($category === '國科會計畫') {
        $stmt = mysqli_prepare($link, "UPDATE NSTCProject SET role=?, nstc_code=?, start_date=?, end_date=? WHERE project_id=?");
        mysqli_stmt_bind_param($stmt, 'ssssi', $role, $nstc_code, $start_date, $end_date, $project_id);
    } else {
        $stmt = mysqli_prepare($link, "UPDATE IndustryProject SET role=?, start_date=?, end_date=? WHERE project_id=?");
        mysqli_stmt_bind_param($stmt, 'sssi', $role, $start_date, $end_date, $project_id);
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
    <title>編輯計畫</title>
    <link rel="stylesheet" href="project_update_style.css">
    <script>
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
<h2>✏️ 編輯計畫資料</h2>
<form method="post" onsubmit="return checkProjectDates();">
    計畫名稱：<input type="text" name="name" value="<?= htmlspecialchars($project['name']) ?>" required><br><br>
    類別：<?= $category ?><br><br>
    擔任角色：<input type="text" name="role" value="<?= htmlspecialchars($role) ?>" required><br><br>
    起始日期：<input type="date" name="start_date" value="<?= $start_date ?>" required><br><br>
    結束日期：<input type="date" name="end_date" value="<?= $end_date ?>" required><br><br>

    <?php if ($category === '國科會計畫'): ?>
        國科會代碼：<input type="text" name="nstc_code" value="<?= htmlspecialchars($nstc_code) ?>"><br><br>
    <?php endif; ?>

    <input type="submit" value="更新" class="btn">
</form>
<p><a href="project_list.php" class="btn-outline">返回計畫列表</a></p>
</div>
</body>
</html>
