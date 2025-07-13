<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];

// 抓老師基本資料
$stmt_info = mysqli_prepare($link, "SELECT * FROM Teacher WHERE teacher_id = ?");
mysqli_stmt_bind_param($stmt_info, 'i', $teacher_id);
mysqli_stmt_execute($stmt_info);
$teacher = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_info));

// 抓課表
$stmt_schedule = mysqli_prepare($link, "SELECT * FROM Schedule WHERE teacher_id = ? ORDER BY FIELD(weekday, '星期一','星期二','星期三','星期四','星期五','星期六','星期日'), start_period");
mysqli_stmt_bind_param($stmt_schedule, 'i', $teacher_id);
mysqli_stmt_execute($stmt_schedule);
$schedule_result = mysqli_stmt_get_result($stmt_schedule);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>老師後台首頁</title>
  <link rel="stylesheet" href="dashboard_style.css">
  
</head>
  <div class = "container"></div>
  <h2>歡迎回來，<?= htmlspecialchars($teacher['name']) ?> 老師</h2>
<div class="info-section">
  <div class="info-block">
    <h3>我的資料</h3>
    <p>姓名：<?= htmlspecialchars($teacher['name']) ?></p>
    <p>Email：<?= htmlspecialchars($teacher['email']) ?></p>
    <p>分機：<?= htmlspecialchars($teacher['extension']) ?></p>
    <p>職位：<?= htmlspecialchars($teacher['position']) ?></p>
  </div>

  <div class="menu-block">
    <h3>功能選單</h3>
    <ul>
      <li><a href="paper_list.php">管理論文</a></li>
      <li><a href="project_list.php">管理計畫</a></li>
      <li><a href="award_list.php">管理獎項</a></li>
      <li><a href="speech_list.php">管理演講</a></li>
      <li><a href="experience_list.php">管理經歷</a></li>
      <li><a href="patent_list.php">管理專利</a></li>
      <li><a href="textbook_list.php">管理教材作品</a></li>
      <li><a href="logout.php">登出</a></li>
    </ul>
  </div>
</div>


  <hr>
  <h3>📘 我的課表</h3>
  <table border="1" cellpadding="10">
    <tr>
      <th>星期</th>
      <th>開始節次</th>
      <th>結束節次</th>
      <th>課程名稱</th>
      <th>班級</th>
      <th>操作</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($schedule_result)): ?>
      <tr>
        <td><?= htmlspecialchars($row['weekday']) ?></td>
        <td><?= $row['start_period'] ?></td>
        <td><?= $row['end_period'] ?></td>
        <td><?= htmlspecialchars($row['course_name']) ?></td>
        <td><?= htmlspecialchars($row['class_name']) ?></td>
        <td>
          <a href="schedule_update.php?weekday=<?= urlencode($row['weekday']) ?>&start_period=<?= $row['start_period'] ?>">編輯</a>
          |
          <a href="schedule_delete.php?weekday=<?= urlencode($row['weekday']) ?>&start_period=<?= $row['start_period'] ?>" onclick="return confirm('確定要刪除這堂課嗎？')">刪除</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
  <p><a href="schedule_insert.php" class="btn"> 新增課程</a></p>
    </div>
</body>
</html>
