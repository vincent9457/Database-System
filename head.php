<?php
// 資料庫連線
require_once 'phpdb.php';

// 取得所有職稱包含「系主任」的老師
$head_sql = "SELECT * FROM Teacher WHERE position LIKE '%系主任%' ORDER BY teacher_id DESC";
$head_result = mysqli_query($link, $head_sql);
$heads = [];
while ($row = mysqli_fetch_assoc($head_result)) {
    $heads[] = $row;
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>系主任資訊 - 資訊工程學系 系所成員系統</title>
  <link rel="stylesheet" href="head_style.css">
</head>
<body>

<header>
  <h1>逢甲大學 資訊工程學系 系所成員</h1>
</header>


  <div class="breadcrumb">
    <a href="Homepage.html">首頁</a>
    <span>›</span>
    <a href="head.php">系主任資訊</a>
  </div>

<div class="layout">
  <aside class="sidebar">
    <ul>
      <li><a href="head.php" class="active">系主任</a></li>
      <li><a href="honorary.php">榮譽特聘講座</a></li>
      <li><a href="chair_prof.php">講座教授</a></li>
      <li><a href="special_lecture.php">特約講座</a></li>
      <li><a href="special_prof.php">特聘教授</a></li>
      <li><a href="fulltime.php">專任教師</a></li>
      <li><a href="part_time.php">兼任教師</a></li>
      <li><a href="administrative.php">行政人員</a></li>
      <li><a href="retired.php">退休教師</a></li>
    </ul>
  </aside>

<main class="content">
  <?php if (count($heads) > 0): ?>
  <?php foreach ($heads as $head): ?>
  <div class="teacher-card">
      <?php if (!empty($head['photo'])): ?>
        <img src="<?= htmlspecialchars($head['photo']) ?>" alt="教師照片">
      <?php endif; ?>
      <div class="info">
        <h3>
          <a href="teacherinfo.php?teacher_id=<?= urlencode($head['teacher_id']) ?>&from=head.php" style="color:inherit;text-decoration:underline;">
            <?= htmlspecialchars($head['name']) ?>
          </a>
        </h3>
          <p><strong>職稱：</strong><?= htmlspecialchars($head['position']) ?></p>
          <?php if (!empty($head['extension'])): ?>
          <p><strong>分機：</strong><?= htmlspecialchars($head['extension']) ?></p>
          <?php endif; ?>
          <?php if (!empty($head['email'])): ?>
          <p><strong>電子郵件：</strong>
          <a href="mailto:<?= htmlspecialchars($head['email']) ?>"><?= htmlspecialchars($head['email']) ?></a>
          </p>
          <?php endif; ?>
            <p>
            <strong>研究領域：</strong>
            <?php
            // 查詢該老師的所有專長
            $tid = $head['teacher_id'];
            $exp_sql = "SELECT expertise FROM TeacherExpertise WHERE teacher_id = $tid";
            $exp_result = mysqli_query($link, $exp_sql);
            $exp_list = [];
            while ($exp = mysqli_fetch_assoc($exp_result)) {
              $exp_list[] = $exp['expertise'];
            }
            echo htmlspecialchars(implode('、', $exp_list));
            ?>
            </p>
        </div>
  </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>目前沒有系主任資料。</p>
  <?php endif; ?>
</main>
</div>

<footer>
  &copy; 2025 資訊工程學系 系所成員系統 ｜ 私立逢甲大學
</footer>
</body>
</html>
<?php
mysqli_close($link);
?>