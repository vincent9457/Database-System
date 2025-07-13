<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? 0;

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // 老師只能改自己的資料
    if (!isset($_SESSION['teacher_id']) || $_SESSION['teacher_id'] != $id) {
        header('Location: login.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $extension = $_POST['extension'];
    $position = $_POST['position'];
    $expertise_input = trim($_POST['expertise']);
    $expertise_array = array_filter(array_map('trim', explode(',', $expertise_input)));

    $edu_degree = $_POST['degree'] ?? [];
    $edu_school = $_POST['school'] ?? [];
    $edu_dept = $_POST['department'] ?? [];

    // 照片處理
    $photo_path = $_POST['original_photo'];
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $filename = uniqid() . '_' . basename($_FILES['photo']['name']);
        $target_file = $upload_dir . $filename;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $photo_path = $target_file;
        }
    }

    // 更新 Teacher
    $stmt = mysqli_prepare($link, "UPDATE Teacher SET name=?, email=?, extension=?, position=?, photo=? WHERE teacher_id=?");
    mysqli_stmt_bind_param($stmt, 'sssssi', $name, $email, $extension, $position, $photo_path, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // 專長清空再寫入
    mysqli_query($link, "DELETE FROM TeacherExpertise WHERE teacher_id = $id");
    foreach ($expertise_array as $exp) {
        $stmt2 = mysqli_prepare($link, "INSERT INTO TeacherExpertise (teacher_id, expertise) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt2, 'is', $id, $exp);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
    }

    // 學歷清空再寫入
    mysqli_query($link, "DELETE FROM Education WHERE teacher_id = $id");
    $edu_count = min(count($edu_degree), count($edu_school), count($edu_dept));
    for ($i = 0; $i < $edu_count; $i++) {
        $degree = trim($edu_degree[$i]);
        $school = trim($edu_school[$i]);
        $department = trim($edu_dept[$i]);
        if ($degree && $school && $department) {
            $stmt3 = mysqli_prepare($link, "INSERT INTO Education (teacher_id, degree, school, department) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt3, 'isss', $id, $degree, $school, $department);
            mysqli_stmt_execute($stmt3);
            mysqli_stmt_close($stmt3);
        }
    }

    header("Location: select576.php");
    exit;
}

// 載入原本資料
$stmt = mysqli_prepare($link, "SELECT * FROM Teacher WHERE teacher_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$teacher = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// 專長
$exp_result = mysqli_query($link, "SELECT expertise FROM TeacherExpertise WHERE teacher_id = $id");
$expertise_list = [];
while ($row = mysqli_fetch_assoc($exp_result)) {
    $expertise_list[] = $row['expertise'];
}
$expertise_str = implode(', ', $expertise_list);

// 學歷
$edu_result = mysqli_query($link, "SELECT * FROM Education WHERE teacher_id = $id");
$edu_degrees = $edu_schools = $edu_departments = [];
while ($row = mysqli_fetch_assoc($edu_result)) {
    $edu_degrees[] = $row['degree'];
    $edu_schools[] = $row['school'];
    $edu_departments[] = $row['department'];
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>編輯教師</title>
    <link rel="stylesheet" href="update576_style.css">
    <style>
        .education-group {
            margin-bottom: 10px;
        }
    </style>
    <script>
        function addEducation() {
            const wrapper = document.getElementById('education-wrapper');
            const group = document.createElement('div');
            group.className = 'education-group';
            group.innerHTML = `
                學位：<input type="text" name="degree[]" required>
                學校：<input type="text" name="school[]" required>
                科系：<input type="text" name="department[]" required>
                <button type="button" onclick="removeEducation(this)">移除</button>
                <br><br>
            `;
            wrapper.appendChild(group);
        }

        function removeEducation(btn) {
            btn.parentElement.remove();
        }
    </script>
</head>
<body>
<div class="container">
<h2>✏️ 編輯教師資料</h2>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="original_photo" value="<?= htmlspecialchars($teacher['photo']) ?>">

    姓名：<input type="text" name="name" value="<?= htmlspecialchars($teacher['name']) ?>" required><br><br>
    Email：<input type="email" name="email" value="<?= htmlspecialchars($teacher['email']) ?>"><br><br>
    分機：<input type="text" name="extension" value="<?= htmlspecialchars($teacher['extension']) ?>"><br><br>
    職位：<input type="text" name="position" value="<?= htmlspecialchars($teacher['position']) ?>"><br><br>
    專長（用逗號分隔）：<input type="text" name="expertise" value="<?= htmlspecialchars($expertise_str) ?>"><br><br>

    <div id="education-wrapper">
        <?php for ($i = 0; $i < count($edu_degrees); $i++): ?>
        <div class="education-group">
            學位：<input type="text" name="degree[]" value="<?= htmlspecialchars($edu_degrees[$i]) ?>" required>
            學校：<input type="text" name="school[]" value="<?= htmlspecialchars($edu_schools[$i]) ?>" required>
            科系：<input type="text" name="department[]" value="<?= htmlspecialchars($edu_departments[$i]) ?>" required>
            <button type="button" onclick="removeEducation(this)">移除</button>
            <br><br>
        </div>
        <?php endfor; ?>
    </div>
    <button type="button" onclick="addEducation()">➕ 新增一筆學歷</button>
    <br><br>

    目前照片：<br>
    <?php if (!empty($teacher['photo'])): ?>
        <img src="<?= htmlspecialchars($teacher['photo']) ?>" width="150" class="teacher-photo"><br><br>
    <?php else: ?>
        無照片<br><br>
    <?php endif; ?>
    上傳新照片：<input type="file" name="photo"><br><br>

    <input type="submit" value="確認送出" class="btn">
</form>
<p><a href="select576.php" class="btn-outline">返回教師列表</a></p>
</div>
</body>
</html>
