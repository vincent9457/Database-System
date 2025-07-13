<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $extension = $_POST['extension'];
    $position = $_POST['position'];
    $expertise_input = trim($_POST['expertise']);
    $expertise_array = array_filter(array_map('trim', explode(',', $expertise_input)));

    // 從動態欄位接收學歷陣列
    $edu_degree = $_POST['degree'] ?? [];
    $edu_school = $_POST['school'] ?? [];
    $edu_dept = $_POST['department'] ?? [];

    // 處理圖片上傳
    $photo_path = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $filename = uniqid() . '_' . basename($_FILES['photo']['name']);
        $target_file = $upload_dir . $filename;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $photo_path = $target_file;
        }
    }

    // 寫入 Teacher
    $stmt = mysqli_prepare($link, "INSERT INTO Teacher (name, email, extension, position, photo) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sssss', $name, $email, $extension, $position, $photo_path);
    if (mysqli_stmt_execute($stmt)) {
        $teacher_id = mysqli_insert_id($link);

        foreach ($expertise_array as $exp) {
            $stmt2 = mysqli_prepare($link, "INSERT INTO TeacherExpertise (teacher_id, expertise) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt2, 'is', $teacher_id, $exp);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt2);
        }

        $edu_count = min(count($edu_degree), count($edu_school), count($edu_dept));
        for ($i = 0; $i < $edu_count; $i++) {
            $degree = trim($edu_degree[$i]);
            $school = trim($edu_school[$i]);
            $department = trim($edu_dept[$i]);
            if ($degree && $school && $department) {
                $stmt3 = mysqli_prepare($link, "INSERT INTO Education (teacher_id, degree, school, department) VALUES (?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt3, 'isss', $teacher_id, $degree, $school, $department);
                mysqli_stmt_execute($stmt3);
                mysqli_stmt_close($stmt3);
            }
        }

        header("Location: select576.php");
        exit;
    } else {
        echo "新增失敗：" . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>新增教師</title>
    <link rel="stylesheet" href="insert576_style.css">
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
<h2>➕ 新增教師資料</h2>
<form method="post" enctype="multipart/form-data">
    姓名：<input type="text" name="name" required><br><br>
    Email：<input type="email" name="email"><br><br>
    分機：<input type="text" name="extension"><br><br>
    職位：<input type="text" name="position"><br><br>
    專長（用逗號分隔）：<input type="text" name="expertise" placeholder="例如：AI, 資料庫"><br><br>

    <div id="education-wrapper">
        <div class="education-group">
            學位：<input type="text" name="degree[]" required>
            學校：<input type="text" name="school[]" required>
            科系：<input type="text" name="department[]" required>
            <button type="button" onclick="removeEducation(this)">移除</button>
            <br><br>
        </div>
    </div>
    <button type="button" onclick="addEducation()">➕ 新增一筆學歷</button>
    <br><br>

    上傳照片：<input type="file" name="photo"><br><br>
    <input type="submit" value="確認送出" class="btn">
</form>
<p><a href="select576.php" class="btn-outline">返回教師清單</a></p>
</div>
</body>
</html>
