<?php
// 資料庫連線
require_once 'phpdb.php';

// 只查詢職稱為「組員」、「技佐」或「書記」的老師
$sql = "SELECT * FROM Teacher WHERE position IN ('組員', '技佐', '書記')";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>行政人員資訊 - 教授資訊網站維護系統</title>
    <link rel="stylesheet" href="administrative_style.css">
    
</head>
<body>

<header>
    <h1>逢甲大學 資訊工程學系 系所成員</h1>
</header>

    <div class="breadcrumb">
    <a href="Homepage.html">首頁</a>
    <span>›</span>
    <a href="administrative.php">行政人員資訊</a>
    </div>

<div class="layout">
  <aside class="sidebar">
    <ul>
      <li><a href="head.php">系主任</a></li>
      <li><a href="honorary.php">榮譽特聘講座</a></li>
      <li><a href="chair_prof.php">講座教授</a></li>
      <li><a href="special_lecture.php">特約講座</a></li>
      <li><a href="special_prof.php">特聘教授</a></li>
      <li><a href="fulltime.php">專任教師</a></li>
      <li><a href="part_time.php">兼任教師</a></li>
      <li><a href="administrative.php" class="active">行政人員</a></li>
      <li><a href="retired.php">退休教師</a></li>
    </ul>
  </aside>

<main class="content">
    <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="teacher-card">
            <?php if (!empty($row['photo'])): ?>
                <img src="<?= htmlspecialchars($row['photo']) ?>" alt="教師照片">
            <?php endif; ?>
            <div class="info">
                <h3>
                    <?= htmlspecialchars($row['name']) ?>
                </h3>
                <p><strong>職稱：</strong><?= htmlspecialchars($row['position']) ?></p>
                <p><strong>分機：</strong><?= htmlspecialchars($row['extension']) ?></p>
                <?php if (!empty($row['email'])): ?>
                <p><strong>電子郵件：</strong>
                    <a href="mailto:<?= htmlspecialchars($row['email']) ?>">
                        <?= htmlspecialchars($row['email']) ?>
                    </a>
                </p>
                <?php endif; ?>
                <p>
                    <strong>負責職掌：</strong>
                    <?php
                    // 查詢該老師的所有專長
                    $tid = $row['teacher_id'];
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
    <?php endwhile; ?>
<?php else: ?>
    <p>目前沒有行政人員資料。</p>
<?php endif; ?>
</main>
</div>

<footer>
    &copy; 2025 資訊系教授資訊系統 ｜ 私立逢甲大學
</footer>

</body>
</html>

<?php
// 關閉連線
mysqli_close($link);
?>
