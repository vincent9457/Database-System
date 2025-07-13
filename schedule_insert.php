<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$error = "";

// 預設值讓表單可回填
$weekday = '';
$start = '';
$end = '';
$course = '';
$class = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $weekday = $_POST['weekday'];
    $start = $_POST['start_period'];
    $end = $_POST['end_period'];
    $course = $_POST['course_name'];
    $class = $_POST['class_name'];

    if (intval($end) < intval($start)) {
        $error = "❌ 結束節次不能小於開始節次";
    } else {
        // 檢查是否有「時間區間重疊」
        $check_sql = "SELECT * FROM Schedule 
                      WHERE teacher_id = ? AND weekday = ?
                      AND NOT (end_period < ? OR start_period > ?)";
        $check_stmt = mysqli_prepare($link, $check_sql);
        mysqli_stmt_bind_param($check_stmt, 'isii', $teacher_id, $weekday, $start, $end);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "❌ 課程時間與其他課表衝堂，請重新選擇節次";
        } else {
            $sql = "INSERT INTO Schedule (teacher_id, weekday, course_name, class_name, start_period, end_period)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, 'isssii', $teacher_id, $weekday, $course, $class, $start, $end);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "❌ 插入失敗，請確認格式正確";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>新增課表</title>
  <link rel="stylesheet" href="schedule_insert_style.css">
</head>
<body>
<div class="container">
  <h2>➕ 新增課表</h2>
  <?php if ($error): ?>
    <script>
      alert("<?= addslashes($error) ?>");
    </script>
  <?php endif; ?>
  <form method="post">
    星期：
    <select name="weekday" required>
      <option value="">請選擇</option>
      <option value="星期一" <?= $weekday=='星期一' ? 'selected' : '' ?>>星期一</option>
      <option value="星期二" <?= $weekday=='星期二' ? 'selected' : '' ?>>星期二</option>
      <option value="星期三" <?= $weekday=='星期三' ? 'selected' : '' ?>>星期三</option>
      <option value="星期四" <?= $weekday=='星期四' ? 'selected' : '' ?>>星期四</option>
      <option value="星期五" <?= $weekday=='星期五' ? 'selected' : '' ?>>星期五</option>
      <option value="星期六" <?= $weekday=='星期六' ? 'selected' : '' ?>>星期六</option>
      <option value="星期日" <?= $weekday=='星期日' ? 'selected' : '' ?>>星期日</option>
    </select><br><br>
    開始節次：<input type="number" name="start_period" min="1" max="14" required value="<?= htmlspecialchars($start) ?>"><br><br>
    結束節次：<input type="number" name="end_period" min="1" max="14" required value="<?= htmlspecialchars($end) ?>"><br><br>
    課程名稱：<input type="text" name="course_name" required value="<?= htmlspecialchars($course) ?>"><br><br>
    班級名稱：<input type="text" name="class_name" required value="<?= htmlspecialchars($class) ?>"><br><br>
    <input type="submit" value="新增課表" class="btn">
  </form>
  <p><a href="dashboard.php" class="btn-outline">返回課表</a></p>
</div>
</body>
</html>
