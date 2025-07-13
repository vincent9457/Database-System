<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$weekday = $_GET['weekday'] ?? '';
$start_period = $_GET['start_period'] ?? 0;
$error = "";

// 取得原始課表資料
$sql = "SELECT * FROM Schedule WHERE teacher_id = ? AND weekday = ? AND start_period = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, 'isi', $teacher_id, $weekday, $start_period);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<p style='color:red;'>找不到該筆課表資料</p><a href='dashboard.php'>返回</a>";
    exit;
}

// 先設好預設值
$form_start   = $data['start_period'];
$form_end     = $data['end_period'];
$form_course  = $data['course_name'];
$form_class   = $data['class_name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_start  = $_POST['start_period'];
    $form_end    = $_POST['end_period'];
    $form_course = $_POST['course_name'];
    $form_class  = $_POST['class_name'];

    if (intval($form_end) < intval($form_start)) {
        $error = "❌ 結束節次不能小於開始節次";
    } else {
        // 檢查是否會與其他課表衝堂（排除自己）
        $check_sql = "SELECT * FROM Schedule 
                      WHERE teacher_id = ? AND weekday = ?
                      AND NOT (end_period < ? OR start_period > ?)
                      AND NOT (start_period = ? AND weekday = ?)";
        $check_stmt = mysqli_prepare($link, $check_sql);
        mysqli_stmt_bind_param($check_stmt, 'isiiis', $teacher_id, $weekday, $form_start, $form_end, $start_period, $weekday);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "❌ 更新後會與其他課程衝堂，請重新調整時間";
        } else {
            $update_sql = "UPDATE Schedule SET course_name = ?, class_name = ?, start_period = ?, end_period = ?
                           WHERE teacher_id = ? AND weekday = ? AND start_period = ?";
            $stmt2 = mysqli_prepare($link, $update_sql);
            mysqli_stmt_bind_param($stmt2, 'ssiisis', $form_course, $form_class, $form_start, $form_end,
                $teacher_id, $weekday, $start_period);

            if (mysqli_stmt_execute($stmt2)) {
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "❌ 更新失敗，請重試";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>編輯課表</title>
  <link rel="stylesheet" href="schedule_update_style.css">
</head>
<body>
<div class="container">
<h2>✏️ 編輯課表</h2>
<?php if ($error): ?>
  <script>
    alert("<?= addslashes($error) ?>");
  </script>
<?php endif; ?>
<form method="post">
  星期：<?= htmlspecialchars($weekday) ?><br><br>
  開始節次：<input type="number" name="start_period" value="<?= htmlspecialchars($form_start) ?>" min="1" max="14" required><br><br>
  結束節次：<input type="number" name="end_period" value="<?= htmlspecialchars($form_end) ?>" min="1" max="14" required><br><br>
  課程名稱：<input type="text" name="course_name" value="<?= htmlspecialchars($form_course) ?>" required><br><br>
  班級名稱：<input type="text" name="class_name" value="<?= htmlspecialchars($form_class) ?>" required><br><br>
  <input type="submit" value="更新" class="btn">
</form>
<p><a href="dashboard.php" class="btn-outline">返回課表</a></p>
</div>
</body>
</html>
