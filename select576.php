<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

$keyword = $_GET['q'] ?? '';
if ($keyword !== '') {
    $kw = '%' . $keyword . '%';
    $stmt = mysqli_prepare($link, "SELECT * FROM Teacher WHERE name LIKE ? OR email LIKE ? OR position LIKE ?");
    mysqli_stmt_bind_param($stmt, 'sss', $kw, $kw, $kw);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $result = mysqli_query($link, "SELECT * FROM Teacher");
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>教師清單</title>
    <link rel="stylesheet" href="select576_style.css">
</head>
<body>
<div class="container">
<h2>教師資料總覽</h2>

<form method="get">
    關鍵字搜尋（姓名、Email、職位）：<input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>">
    <input type="submit" value="搜尋" class="btn">
</form>

<p><a href="insert576.php" class="btn">➕ 新增教師</a></p>
<p><a href="logout.php" class="btn">登出</a></p>
<table border="1" cellpadding="10">
    <tr>
        <!-- <th>ID</th> -->
        <th>姓名</th>
        <th>Email</th>
        <th>分機</th>
        <th>職位</th>
        <th>專長</th>
        <th>學歷</th>
        <th>照片</th>
        <th>操作</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <!-- <td><?= $row['teacher_id'] ?></td> -->
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['extension']) ?></td>
        <td><?= htmlspecialchars($row['position']) ?></td>
        <td>
            <?php
            $tid = $row['teacher_id'];
            $exp_result = mysqli_query($link, "SELECT expertise FROM TeacherExpertise WHERE teacher_id = $tid");
            $exp_list = [];
            while ($exp = mysqli_fetch_assoc($exp_result)) {
                $exp_list[] = $exp['expertise'];
            }
            echo htmlspecialchars(implode(', ', $exp_list));
            ?>
        </td>
        <td>
            <?php
            $edu_result = mysqli_query($link, "SELECT degree, school FROM Education WHERE teacher_id = $tid");
            $edu_list = [];
            while ($edu = mysqli_fetch_assoc($edu_result)) {
                $edu_list[] = $edu['degree'] . '（' . $edu['school'] . '）';
            }
            echo implode('<br>', array_map('htmlspecialchars', $edu_list));
            ?>
        </td>
        <td>
            <?php if (!empty($row['photo'])): ?>
                <img src="<?= htmlspecialchars($row['photo']) ?>" width="100">
            <?php else: ?>
                無照片
            <?php endif; ?>
        </td>
        <td>
            <a href="update576.php?id=<?= $row['teacher_id'] ?>">編輯</a> |
            <a href="delete576.php?id=<?= $row['teacher_id'] ?>" onclick="return confirm('確定要刪除嗎？')">刪除</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</div>
</body>
</html>
