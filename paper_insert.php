<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $author_input = trim($_POST['authors']);
    $authors = array_filter(array_map('trim', explode(',', $author_input)));

    $stmt = mysqli_prepare($link, "INSERT INTO Paper (title, category, teacher_id) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssi', $title, $category, $teacher_id);
    if (mysqli_stmt_execute($stmt)) {
        $paper_id = mysqli_insert_id($link);

        switch ($category) {
            case '專書論文':
                $sql = "INSERT INTO BookPaper (paper_id, name, pages, publish_date, publisher) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($link, $sql);
                mysqli_stmt_bind_param($stmt, 'issss', $paper_id, $_POST['name'], $_POST['pages'], $_POST['publish_date'], $_POST['publisher']);
                mysqli_stmt_execute($stmt);
                foreach ($authors as $author) {
                    $stmt2 = mysqli_prepare($link, "INSERT INTO BookPaperAuthor (paper_id, author) VALUES (?, ?)");
                    mysqli_stmt_bind_param($stmt2, 'is', $paper_id, $author);
                    mysqli_stmt_execute($stmt2);
                }
                break;

            case '會議論文':
                $sql = "INSERT INTO ConferencePaper (paper_id, conf_date, school, conference_name) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($link, $sql);
                mysqli_stmt_bind_param($stmt, 'isss', $paper_id, $_POST['conf_date'], $_POST['school'], $_POST['conference_name']);
                mysqli_stmt_execute($stmt);
                foreach ($authors as $author) {
                    $stmt2 = mysqli_prepare($link, "INSERT INTO ConferencePaperAuthor (paper_id, author) VALUES (?, ?)");
                    mysqli_stmt_bind_param($stmt2, 'is', $paper_id, $author);
                    mysqli_stmt_execute($stmt2);
                }
                break;

            case '專書和技術報告':
                $sql = "INSERT INTO TechReport (paper_id, publish_date, pages, publisher, publish_place) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($link, $sql);
                mysqli_stmt_bind_param($stmt, 'issss', $paper_id, $_POST['publish_date'], $_POST['pages'], $_POST['publisher'], $_POST['publish_place']);
                mysqli_stmt_execute($stmt);
                foreach ($authors as $author) {
                    $stmt2 = mysqli_prepare($link, "INSERT INTO TechReportAuthor (paper_id, author) VALUES (?, ?)");
                    mysqli_stmt_bind_param($stmt2, 'is', $paper_id, $author);
                    mysqli_stmt_execute($stmt2);
                }
                break;

            case '期刊論文':
                $sql = "INSERT INTO JournalPaper (paper_id, publish_date, pages, volume) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($link, $sql);
                mysqli_stmt_bind_param($stmt, 'isss', $paper_id, $_POST['publish_date'], $_POST['pages'], $_POST['volume']);
                mysqli_stmt_execute($stmt);
                foreach ($authors as $author) {
                    $stmt2 = mysqli_prepare($link, "INSERT INTO JournalPaperAuthor (paper_id, author) VALUES (?, ?)");
                    mysqli_stmt_bind_param($stmt2, 'is', $paper_id, $author);
                    mysqli_stmt_execute($stmt2);
                }
                break;
        }

        header("Location: paper_list.php");
        exit;
    } else {
        $error = "❌ 新增失敗，請確認欄位正確";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新增論文</title>
    <link rel="stylesheet" href="paper_insert_style.css">
    <script>
    function showCategoryFields() {
        const val = document.getElementById('category').value;
        document.querySelectorAll('.category-group').forEach(div => {
            // 清空該區塊所有 input
            Array.from(div.querySelectorAll('input')).forEach(input => {
                input.value = '';
                input.disabled = true;
            });
            div.style.display = 'none';
        });
        if (val) {
            const active = document.getElementById(val);
            active.style.display = 'block';
            Array.from(active.querySelectorAll('input')).forEach(input => {
                input.disabled = false;
            });
        }
    }
    window.onload = showCategoryFields;

    function checkDatesNotFuture() {
        // 取得今天日期 yyyy-mm-dd
        var today = new Date();
        var yyyy = today.getFullYear();
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var dd = String(today.getDate()).padStart(2, '0');
        var todayStr = yyyy + '-' + mm + '-' + dd;

        // 所有類型可能用到的日期欄位 name
        var dateFields = [
            'publish_date',     // 專書論文, 專書和技術報告, 期刊論文
            'conf_date'         // 會議論文
        ];
        for (var i = 0; i < dateFields.length; i++) {
            var inputs = document.getElementsByName(dateFields[i]);
            for (var j = 0; j < inputs.length; j++) {
                var v = inputs[j].value;
                if (v && v > todayStr) {
                    alert("❌ 論文出版/會議日期不可大於今天！");
                    return false;
                }
            }
        }
        return true;
    }
    </script>
</head>
<body>
<div class="container">

<h2>➕ 新增論文</h2>
<?php if ($error): ?>
    <div style="color:red;margin-bottom:10px;"><?php echo $error; ?></div>
<?php endif; ?>
<form action="paper_insert.php" method="post" onsubmit="return checkDatesNotFuture();">
  <label for="title">論文標題：</label>
  <input type="text" name="title" id="title" required>

  <label for="category">類型：</label>
  <select name="category" id="category" onchange="showCategoryFields()" required>
    <option value="">請選擇</option>
    <option value="專書論文">專書論文</option>
    <option value="會議論文">會議論文</option>
    <option value="專書和技術報告">專書和技術報告</option>
    <option value="期刊論文">期刊論文</option>
  </select>

  <!-- 專書論文 -->
  <div class="category-group" id="專書論文" style="display:none">
    <label for="name">專書名稱：</label>
    <input type="text" name="name" id="name" disabled>
    <label for="pages">頁數：</label>
    <input type="text" name="pages" id="pages" disabled>
    <label for="publish_date">出版日期：</label>
    <input type="date" name="publish_date" id="publish_date" disabled>
    <label for="publisher">出版社：</label>
    <input type="text" name="publisher" id="publisher" disabled>
  </div>

  <!-- 會議論文 -->
  <div class="category-group" id="會議論文" style="display:none">
    <label for="conf_date">會議日期：</label>
    <input type="date" name="conf_date" id="conf_date" disabled>
    <label for="school">主辦單位：</label>
    <input type="text" name="school" id="school" disabled>
    <label for="conference_name">會議名稱：</label>
    <input type="text" name="conference_name" id="conference_name" disabled>
  </div>

  <!-- 專書和技術報告 -->
  <div class="category-group" id="專書和技術報告" style="display:none">
    <label for="publish_date_tr">出版日期：</label>
    <input type="date" name="publish_date" id="publish_date_tr" disabled>
    <label for="pages_tr">頁數：</label>
    <input type="text" name="pages" id="pages_tr" disabled>
    <label for="publisher_tr">出版社：</label>
    <input type="text" name="publisher" id="publisher_tr" disabled>
    <label for="publish_place">出版地：</label>
    <input type="text" name="publish_place" id="publish_place" disabled>
  </div>

  <!-- 期刊論文 -->
  <div class="category-group" id="期刊論文" style="display:none">
    <label for="publish_date_jp">出版日期：</label>
    <input type="date" name="publish_date" id="publish_date_jp" disabled>
    <label for="pages_jp">頁數：</label>
    <input type="text" name="pages" id="pages_jp" disabled>
    <label for="volume">卷期：</label>
    <input type="text" name="volume" id="volume" disabled>
  </div>

  <h4>作者（用逗號分隔）：</h4>
  <input type="text" name="authors" placeholder="例如：王大明,李小花,陳永仁">

  <input type="submit" value="確認送出" class="btn">
</form>
<a href="paper_list.php" class="btn-outline">返回論文列表</a>

</div>
</body>
</html>
