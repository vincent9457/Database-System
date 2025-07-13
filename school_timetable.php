<?php
// 資料庫連線
require_once 'phpdb.php';

// 查詢老師個人資料
$teacher_id = isset($_GET['teacher_id']) ? $_GET['teacher_id'] : '13'; // 預設13，可改
$teacher_sql = "SELECT * FROM Teacher WHERE teacher_id = '$teacher_id'";
$teacher_result = mysqli_query($link, $teacher_sql);
$teacher_info = mysqli_fetch_assoc($teacher_result);

// 查詢課表資料
$schedule_sql = "SELECT weekday, course_name, class_name, start_period, end_period FROM Schedule WHERE teacher_id = '$teacher_id'";
$schedule_result = mysqli_query($link, $schedule_sql);

// 定義節次與時間
$periods = [
    1 => '08:10~09:00',
    2 => '09:10~10:00',
    3 => '10:10~11:00',
    4 => '11:10~12:00',
    5 => '12:10~13:00',
    6 => '13:10~14:00',
    7 => '14:10~15:00',
    8 => '15:10~16:00',
    9 => '16:10~17:00',
    10 => '17:10~18:00',
    11 => '18:10~19:00',
    12 => '19:10~20:00',
    13 => '20:10~21:00',
    14 => '21:10~22:00',
];
$weekdays = ['星期一','星期二','星期三','星期四','星期五','星期六','星期日'];

// 建立空課表陣列
$timetable = [];
foreach ($periods as $p => $time) {
    foreach ($weekdays as $w) {
        $timetable[$p][$w] = '-';
    }
}

// 填入課表資料
if ($schedule_result && mysqli_num_rows($schedule_result) > 0) {
    while ($row = mysqli_fetch_assoc($schedule_result)) {
        for ($p = $row['start_period']; $p <= $row['end_period']; $p++) {
            $timetable[$p][$row['weekday']] = htmlspecialchars($row['course_name']) . "<br>" . htmlspecialchars($row['class_name']);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>教師課表 - 資訊工程學系 系所成員系統</title>
    <link rel="stylesheet" href="school_timetable_style.css">
</head>
<body>

<header>
    <h1>教師課表</h1>
</header>

<?php $from = isset($_GET['from']) ? $_GET['from'] : 'fulltime.php'; ?>

<main>
<div class="breadcrumb">
    <a href="Homepage.html">首頁</a>
    <span>›</span>
    <?php
    // 根據 $from 參數決定顯示文字
    $from_display = '專任教師資訊';
    switch ($from) {
        case 'honorary.php':
            $from_display = '榮譽特聘講座資訊';
            break;
        case 'chair_prof.php':
            $from_display = '講座教授資訊';
            break;
        case 'special_lecture.php':
            $from_display = '特約講座資訊';
            break;
        case 'special_prof.php':
            $from_display = '特聘教授資訊';
            break;
        case 'fulltime.php':
            $from_display = '專任教師資訊';
            break;
        case 'part_time.php':
            $from_display = '兼任教師資訊';
            break;
        case 'administrative.php':
            $from_display = '行政人員資訊';
            break;
        case 'retired.php':
            $from_display = '退休教師資訊';
            break;
        case 'head.php':
            $from_display = '系主任資訊';
            break;
        default:
            $from_display = '專任教師資訊';
            break;
    }
    // 其他頁面可依需求擴充
    ?>
    <a href="<?= htmlspecialchars($from) ?>"><?= htmlspecialchars($from_display) ?></a>
    <span>›</span>
    <a href="teacherinfo.php?teacher_id=<?= urlencode($teacher_id) ?>&from=<?= urlencode($from) ?>">教師個人資訊</a>
    <span>›</span>
    <a href="school_timetable.php?teacher_id=<?= urlencode($teacher_id) ?>&from=<?= urlencode($from) ?>">教師課表</a>
    </div>
    

    <?php if ($teacher_info): ?>
        <section class="teacher-header">
            <div>
                <h2><?= htmlspecialchars($teacher_info['name']) ?></h2>
                <p><strong>職稱：</strong><?= htmlspecialchars($teacher_info['position']) ?></p>
                <p><strong>分機：</strong><?= htmlspecialchars($teacher_info['extension']) ?></p>
                <p><strong>電子郵件：</strong><?= htmlspecialchars($teacher_info['email']) ?></p>
                <p>
                    <strong>研究領域：</strong>
                    <?php
                    // 查詢該老師的所有專長
                    $tid = $teacher_info['teacher_id'];
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
            <?php if (!empty($teacher_info['photo'])): ?>
                <img src="<?= htmlspecialchars($teacher_info['photo']) ?>" alt="教師照片" style="height:150px;width:150px;object-fit:cover;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,0.13);margin-left:32px;margin-right:0;">
            <?php endif; ?>
        </section>
    <?php endif; ?>

    <table class="styled-table">
        <tr>
            <th>節次</th>
            <th>時間</th>
            <?php foreach ($weekdays as $w): ?>
                <th><?= $w ?></th>
            <?php endforeach; ?>
        </tr>
        <?php foreach ($periods as $p => $time): ?>
            <tr>
                <td>第<?= $p ?>節</td>
                <td><?= $time ?></td>
                <?php foreach ($weekdays as $w): ?>
                    <td><?= $timetable[$p][$w] ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</main>

<footer>
    &copy; 2025 資訊系教授資訊系統 ｜ 私立逢甲大學
</footer>

</body>
</html>

<?php
// 關閉連線
mysqli_close($link);
?>
