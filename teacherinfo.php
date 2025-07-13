<?php
// 資料庫連線
require_once 'phpdb.php';

$teacher_id = isset($_GET['teacher_id']) ? $_GET['teacher_id'] : '';
if ($teacher_id !== '') {
    $sql = "SELECT * FROM Teacher WHERE teacher_id = '$teacher_id'";
} else {
    $sql = "SELECT * FROM Teacher"; // 或顯示全部
}
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>教師資訊 - 資訊工程學系 系所成員系統</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="teacherinfo_style.css">
</head>
<body>

<header>
    <h1>教師個人資訊</h1>
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
    </div>
<?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <!-- 第一個 container：基本資料 -->
        <section style="background:#fff; margin-bottom:20px; border-radius:8px; box-shadow:0 0 8px rgba(0,0,0,0.08); padding:24px;">
            <div style="display:flex;align-items:flex-start;gap:32px;">
                <div style="flex:1;">
                    <h2 class="section-title" style="margin-bottom:8px;">
                        <?= htmlspecialchars($row['name']) ?>
                    </h2>
                    <div style="margin-bottom:8px; font-size:1.1em;">
                        <strong>職稱：</strong><?= htmlspecialchars($row['position']) ?>
                    </div>
                    <div style="margin-bottom:8px;">
                        <strong>電子郵件：</strong><?= htmlspecialchars($row['email']) ?>
                        <span style="margin-left:20px;"><strong>分機：</strong><?= htmlspecialchars($row['extension']) ?></span>
                    </div>
                    <div style="margin-bottom:8px;">
                        <strong>課表：</strong>
                        <a href="school_timetable.php?teacher_id=<?= $row['teacher_id'] ?>&from=<?= urlencode($from) ?>">查看課表</a>                    </div>
                </div>
                <?php if (!empty($row['photo'])): ?>
                    <img src="<?= htmlspecialchars($row['photo']) ?>" alt="教師照片" class="teacher-photo" style="height:150px;width:auto;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.10);margin-left:32px;margin-right:0;">
                <?php endif; ?>
            </div>
        </section>

        <!-- 第二個 container：學經歷 -->
        <section style="background:#fff; margin-bottom:20px; border-radius:8px; box-shadow:0 0 8px rgba(0,0,0,0.08); padding:24px;">
            <div style="display:flex;gap:40px;">
                <div style="flex:1;">
                    <div class="block-title">學歷</div>
                    <ul>
                        <?php
                        $tid = $row['teacher_id'];
                        $edu_sql = "SELECT degree, department, school FROM Education WHERE teacher_id = $tid";
                        $edu_result = mysqli_query($link, $edu_sql);
                        while ($edu = mysqli_fetch_assoc($edu_result)) {
                            echo '<li>' . htmlspecialchars($edu['school']) . ' ' . htmlspecialchars($edu['department']) . ' ' . htmlspecialchars($edu['degree']) . '</li>';
                        }
                        ?>
                    </ul>
                    <div class="block-title">專長</div>
                    <ul>
                        <?php
                        $exp_sql = "SELECT expertise FROM TeacherExpertise WHERE teacher_id = $tid";
                        $exp_result = mysqli_query($link, $exp_sql);
                        while ($exp = mysqli_fetch_assoc($exp_result)) {
                            echo '<li>' . htmlspecialchars($exp['expertise']) . '</li>';
                        }
                        ?>
                    </ul>
                </div>
                <div style="flex:1;">
                    <div class="block-title">校內經歷</div>
                    <ul>
                        <?php
                        $in_sql = "SELECT organization, role, school FROM Experience WHERE teacher_id = $tid AND category = '校內'";
                        $in_result = mysqli_query($link, $in_sql);
                        while ($in = mysqli_fetch_assoc($in_result)) {
                            echo '<li>' . htmlspecialchars($in['organization']) . '｜' . htmlspecialchars($in['role']);
                            if (!empty($in['school'])) {
                                echo '｜' . htmlspecialchars($in['school']);
                            }
                            echo '</li>';
                        }
                        ?>
                    </ul>
                    <div class="block-title">校外經歷</div>
                    <ul>
                        <?php
                        $out_sql = "SELECT organization, role, school FROM Experience WHERE teacher_id = $tid AND category = '校外'";
                        $out_result = mysqli_query($link, $out_sql);
                        while ($out = mysqli_fetch_assoc($out_result)) {
                            echo '<li>' . htmlspecialchars($out['organization']) . '｜' . htmlspecialchars($out['role']);
                            if (!empty($out['school'])) {
                                echo '｜' . htmlspecialchars($out['school']);
                            }
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </section>

        <!-- 第三個 container：論文及計畫與獎勵 -->
        <section class="paper-section" style="background:#fff; margin-bottom:20px; border-radius:8px; box-shadow:0 0 8px rgba(0,0,0,0.08); padding:24px;">
            <div class="block-title" style="cursor:default; text-align:center;">
                論文及參與計畫
                <span class="toggle-indicator" style="font-size:0.9em;color:#888;margin-left:8px;cursor:pointer;">[全部收合]</span>
            </div>
            <div class="paper-content">
                <div class="block-title" style="font-size:1em;">
                    <button type="button" class="toggle-sub-btn" aria-label="展開">
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    發表期刊論文
                </div>
                <ul class="sub-content">
                    <?php
                    $jp_sql = "SELECT jp.paper_id, jp.publish_date, jp.pages, jp.volume, p.title
                               FROM JournalPaper jp
                               JOIN Paper p ON jp.paper_id = p.paper_id
                               WHERE p.teacher_id = $tid";
                    $jp_result = mysqli_query($link, $jp_sql);
                    while ($jp = mysqli_fetch_assoc($jp_result)) {
                        $author_sql = "SELECT author FROM JournalPaperAuthor WHERE paper_id = " . $jp['paper_id'];
                        $author_result = mysqli_query($link, $author_sql);
                        $authors = [];
                        while ($a = mysqli_fetch_assoc($author_result)) {
                            $authors[] = htmlspecialchars($a['author']);
                        }
                        echo '<li>'
                            . '標題：' . htmlspecialchars($jp['title'])
                            . '，發表日期：' . htmlspecialchars($jp['publish_date'])
                            . '，頁數：' . htmlspecialchars($jp['pages'])
                            . '，卷期：' . htmlspecialchars($jp['volume'])
                            . '，作者：' . implode(', ', $authors)
                            . '</li>';
                    }
                    ?>
                </ul>

                <div class="block-title" style="font-size:1em;">
                    <button type="button" class="toggle-sub-btn" aria-label="收合">
                        <i class="fa-solid fa-chevron-up"></i>
                    </button>
                    會議論文
                </div>
                <ul class="sub-content">
                    <?php
                    $jp_sql = "SELECT jp.paper_id, jp.conf_date, jp.school, jp.conference_name, p.title
                               FROM ConferencePaper jp
                               JOIN Paper p ON jp.paper_id = p.paper_id
                               WHERE p.teacher_id = $tid";
                    $jp_result = mysqli_query($link, $jp_sql);
                    while ($jp = mysqli_fetch_assoc($jp_result)) {
                        $author_sql = "SELECT author FROM ConferencePaperAuthor WHERE paper_id = " . $jp['paper_id'];
                        $author_result = mysqli_query($link, $author_sql);
                        $authors = [];
                        while ($a = mysqli_fetch_assoc($author_result)) {
                            $authors[] = htmlspecialchars($a['author']);
                        }
                        echo '<li>'
                            . '標題：' . htmlspecialchars($jp['title'])
                            . '，日期：' . htmlspecialchars($jp['conf_date'])
                            . '，主辦單位：' . htmlspecialchars($jp['school'])
                            . '，會議名稱：' . htmlspecialchars($jp['conference_name'])
                            . '，作者：' . implode(', ', $authors)
                            . '</li>';
                    }
                    ?>
                </ul>

                <div class="block-title" style="font-size:1em;">
                    <button type="button" class="toggle-sub-btn" aria-label="收合">
                        <i class="fa-solid fa-chevron-up"></i>
                    </button>
                    專書及技術報告
                </div>
                <ul class="sub-content">
                <?php
                $jp_sql = "SELECT jp.paper_id, jp.publish_date, jp.pages, jp.publisher, jp.publish_place, p.title
                        FROM TechReport jp
                        JOIN Paper p ON jp.paper_id = p.paper_id
                        WHERE p.teacher_id = $tid AND p.category = '專書和技術報告'";
                $jp_result = mysqli_query($link, $jp_sql);
                while ($jp = mysqli_fetch_assoc($jp_result)) {
                    $author_sql = "SELECT author FROM TechReportAuthor WHERE paper_id = " . $jp['paper_id'];
                    $author_result = mysqli_query($link, $author_sql);
                    $authors = [];
                    while ($a = mysqli_fetch_assoc($author_result)) {
                        $authors[] = htmlspecialchars($a['author']);
                    }
                    echo '<li>'
                        . '標題：' . htmlspecialchars($jp['title'])
                        . '，日期：' . htmlspecialchars($jp['publish_date'])
                        . '，頁數：' . htmlspecialchars($jp['pages'])
                        . '，出版社：' . htmlspecialchars($jp['publisher'])
                        . '，出版地：' . htmlspecialchars($jp['publish_place'])
                        . '，作者：' . implode(', ', $authors)
                        . '</li>';
                }
                ?>
                </ul>

                <div class="block-title" style="font-size:1em;">
                    <button type="button" class="toggle-sub-btn" aria-label="收合">
                        <i class="fa-solid fa-chevron-up"></i>
                    </button>
                    專書論文
                </div>
                <ul class="sub-content">
                    <?php
                    $bp_sql =   "SELECT bp.paper_id, bp.name, bp.pages, bp.publish_date, bp.publisher,
                                p.title, p.category, p.teacher_id
                                FROM BookPaper bp
                                JOIN Paper p ON bp.paper_id = p.paper_id
                                WHERE p.teacher_id = $tid";
                    $bp_result = mysqli_query($link, $bp_sql);
                    while ($bp = mysqli_fetch_assoc($bp_result)) {
                        $author_sql = "SELECT author FROM BookPaperAuthor WHERE paper_id = " . $bp['paper_id'];
                        $author_result = mysqli_query($link, $author_sql);
                        $authors = [];
                        while ($a = mysqli_fetch_assoc($author_result)) {
                            $authors[] = htmlspecialchars($a['author']);
                        }
                        echo '<li>'
                            . '標題：' . htmlspecialchars($bp['title'])
                            . '，名稱：' . htmlspecialchars($bp['name'])
                            . '，發表日期：' . htmlspecialchars($bp['publish_date'])
                            . '，頁數：' . htmlspecialchars($bp['pages'])
                            . '，出版社：' . htmlspecialchars($bp['publisher'])
                            . '，作者：' . implode(', ', $authors)
                            . '</li>';
                    }
                    ?>
                </ul>

                <div class="block-title" style="font-size:1em;">
                    <button type="button" class="toggle-sub-btn" aria-label="收合">
                        <i class="fa-solid fa-chevron-up"></i>
                    </button>
                    國科會計畫
                </div>
                <ul class="sub-content">
                    <?php
                    $np_sql = "SELECT np.project_id, np.role, np.nstc_code, np.start_date, np.end_date,
                                        p.name, p.category, p.teacher_id
                                FROM NSTCProject np
                                JOIN Project p ON np.project_id = p.project_id
                                WHERE p.teacher_id = $tid";
                    $np_result = mysqli_query($link, $np_sql);
                    while ($np = mysqli_fetch_assoc($np_result)) {
                        echo '<li>'
                            . '計畫名稱：' . htmlspecialchars($np['name'])
                            . '，角色：' . htmlspecialchars($np['role'])
                            . '，起始日：' . htmlspecialchars($np['start_date'])
                            . '，結束日：' . htmlspecialchars($np['end_date'])
                            . '，國科會編號：' . htmlspecialchars($np['nstc_code'])
                            . '</li>';
                    }
                    ?>
                </ul>

                <div class="block-title" style="font-size:1em;">
                    <button type="button" class="toggle-sub-btn" aria-label="收合">
                        <i class="fa-solid fa-chevron-up"></i>
                    </button>
                    產學合作計畫
                </div>
                <ul class="sub-content">
                    <?php
                    $ip_sql = "SELECT ip.project_id, ip.role, ip.start_date, ip.end_date,
                                        p.name, p.category, p.teacher_id
                                FROM IndustryProject ip
                                JOIN Project p ON ip.project_id = p.project_id
                                WHERE p.teacher_id = $tid";
                    $ip_result = mysqli_query($link, $ip_sql);
                    while ($ip = mysqli_fetch_assoc($ip_result)) {
                        echo '<li>'
                            . '計畫名稱：' . htmlspecialchars($ip['name'])
                            . '，角色：' . htmlspecialchars($ip['role'])
                            . '，起始日：' . htmlspecialchars($ip['start_date'])
                            . '，結束日：' . htmlspecialchars($ip['end_date'])
                            . '</li>';
                    }
                    ?>
                </ul>

                <div class="block-title" style="font-size:1em;">
                    <button type="button" class="toggle-sub-btn" aria-label="收合">
                        <i class="fa-solid fa-chevron-up"></i>
                    </button>
                    校外獎勵及指導學生獲獎
                </div>
                <ul class="sub-content">
                    <?php
                    $ia_sql = "SELECT 
                            ea.name, 
                            ea.date, 
                            ea.organizer, 
                            ea.result,
                            GROUP_CONCAT(eas.student SEPARATOR ', ') AS students
                        FROM ExternalAward ea
                        LEFT JOIN ExternalAwardStudent eas 
                            ON ea.teacher_id = eas.teacher_id 
                            AND ea.name = eas.name 
                            AND ea.date = eas.date
                        WHERE ea.teacher_id = $tid
                        GROUP BY ea.name, ea.date, ea.organizer, ea.result
                    ";
                    $ia_result = mysqli_query($link, $ia_sql);
                    while ($ia = mysqli_fetch_assoc($ia_result)) {
                        echo '<li>'
                            . '名稱：' . htmlspecialchars($ia['name'])
                            . '，日期：' . htmlspecialchars($ia['date'])
                            . '，主辦單位：' . htmlspecialchars($ia['organizer'])
                            . '，結果：' . htmlspecialchars($ia['result'])
                            . '，獲獎學生：' . htmlspecialchars($ia['students'])
                            . '</li>';
                    }
                    ?>
                </ul>

                <div class="block-title" style="font-size:1em;">
                    <button type="button" class="toggle-sub-btn" aria-label="收合">
                        <i class="fa-solid fa-chevron-up"></i>
                    </button>
                    校內獎勵及指導學生獲獎
                </div>
                <ul class="sub-content">
                    <?php
                    $ea_sql = "SELECT name, award, organizer, award_date FROM InternalAward WHERE teacher_id = $tid";
                    $ea_result = mysqli_query($link, $ea_sql);
                    while ($ea = mysqli_fetch_assoc($ea_result)) {
                        echo '<li>'
                            . '名稱：' . htmlspecialchars($ea['name'])
                            . '，項目：' . htmlspecialchars($ea['award'])
                            . '，主辦單位：' . htmlspecialchars($ea['organizer'])
                            . '，日期：' . htmlspecialchars($ea['award_date'])
                            . '</li>';
                    }
                    ?>
                </ul>

                <div class="block-title" style="font-size:1em;">
                    <button type="button" class="toggle-sub-btn" aria-label="收合">
                        <i class="fa-solid fa-chevron-up"></i>
                    </button>
                    校內外演講
                </div>
                <ul class="sub-content">
                    <?php
                    $sp_sql = "SELECT date, topic, organizer FROM Speech WHERE teacher_id = $tid";
                    $sp_result = mysqli_query($link, $sp_sql);
                    while ($sp = mysqli_fetch_assoc($sp_result)) {
                        echo '<li>'
                            . '日期：' . htmlspecialchars($sp['date'])
                            . '，主題：' . htmlspecialchars($sp['topic'])
                            . '，主辦單位：' . htmlspecialchars($sp['organizer'])
                            . '</li>';
                    }
                    ?>
                </ul>

                <div class="block-title" style="font-size:1em;">
                    <button type="button" class="toggle-sub-btn" aria-label="收合">
                        <i class="fa-solid fa-chevron-up"></i>
                    </button>
                    教材與作品
                </div>
                <ul class="sub-content">
                    <?php
                    $tb_sql = "SELECT tb.textbook_id, tb.name, tb.publisher
                            FROM Textbook tb
                            WHERE tb.teacher_id = $tid";
                    $tb_result = mysqli_query($link, $tb_sql);
                    while ($tb = mysqli_fetch_assoc($tb_result)) {
                        $author_sql = "SELECT author FROM TextbookAuthor WHERE textbook_id = " . $tb['textbook_id'];
                        $author_result = mysqli_query($link, $author_sql);
                        $authors = [];
                        while ($a = mysqli_fetch_assoc($author_result)) {
                            $authors[] = htmlspecialchars($a['author']);
                        }
                        echo '<li>'
                            . '名稱：' . htmlspecialchars($tb['name'])
                            . '，出版社：' . htmlspecialchars($tb['publisher'])
                            . '，作者：' . implode(', ', $authors)
                            . '</li>';
                    }
                    ?>
                </ul>

                <div class="block-title" style="font-size:1em;">
                    <button type="button" class="toggle-sub-btn" aria-label="收合">
                        <i class="fa-solid fa-chevron-up"></i>
                    </button>
                    核准專利
                </div>
                <ul class="sub-content">
                    <?php
                    $ea_sql = "SELECT title, type, number, start_date, end_date FROM Patent WHERE teacher_id = $tid";
                    $ea_result = mysqli_query($link, $ea_sql);
                    while ($ea = mysqli_fetch_assoc($ea_result)) {
                        echo '<li>'
                            . '名稱：' . htmlspecialchars($ea['title'])
                            . '，類型：' . htmlspecialchars($ea['type'])
                            . '，編號：' . htmlspecialchars($ea['number'])
                            . '，開始日期：' . htmlspecialchars($ea['start_date'])                            
                            . '，結束日期：' . htmlspecialchars($ea['end_date'])
                            . '</li>';
                    }
                    ?>
                </ul>
            </div>
        </section>
    <?php endwhile; ?>
<?php else: ?>
    <p>目前沒有教師資料。</p>
<?php endif; ?>
</main>

<footer>
    &copy; 2025 資訊系教授資訊系統 ｜ 私立逢甲大學
</footer>

<script>
function togglePaperContent(titleDiv) {
    const section = titleDiv.closest('.paper-section');
    const content = section.querySelector('.paper-content');
    const indicator = section.querySelector('.toggle-indicator');
    if (content.style.display === 'none') {
        content.style.display = '';
        indicator.textContent = '[全部收合]';
    } else {
        content.style.display = 'none';
        indicator.textContent = '[全部展開]';
    }
}

// 預設所有子內容展開，icon朝下
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.sub-content').forEach(function(ul) {
        ul.style.display = 'block';
    });
    document.querySelectorAll('.toggle-sub-btn').forEach(function(btn) {
        btn.setAttribute('aria-label', '展開');
        const icon = btn.querySelector('i');
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
    });

    // 只讓 .toggle-indicator 這個 span 有切換全部展開/收合的功能
    document.querySelectorAll('.toggle-indicator').forEach(function(indicator) {
        indicator.style.cursor = 'pointer';
        indicator.addEventListener('click', function(e) {
            e.stopPropagation();
            const section = indicator.closest('.paper-section');
            const allUl = section.querySelectorAll('.sub-content');
            const allBtn = section.querySelectorAll('.toggle-sub-btn');
            // 判斷目前是否要展開還是收合
            const isExpand = indicator.textContent === '[全部展開]';
            allUl.forEach(function(ul) {
                ul.style.display = isExpand ? 'block' : 'none';
            });
            allBtn.forEach(function(btn) {
                const icon = btn.querySelector('i');
                if (isExpand) {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                    btn.setAttribute('aria-label', '展開');
                } else {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                    btn.setAttribute('aria-label', '收合');
                }
            });
            indicator.textContent = isExpand ? '[全部收合]' : '[全部展開]';
        });
    });
});

// 子區塊展開/收合功能（展開：chevron-down，收合：chevron-up）
document.querySelectorAll('.toggle-sub-btn').forEach(function(btn) {
    btn.onclick = function() {
        const ul = btn.parentElement.nextElementSibling;
        const icon = btn.querySelector('i');
        // 找到最近的 .paper-section，並取得 .toggle-indicator
        const paperSection = btn.closest('.paper-section');
        const indicator = paperSection ? paperSection.querySelector('.toggle-indicator') : null;
        if (ul.style.display === 'none') {
            ul.style.display = 'block';
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
            btn.setAttribute('aria-label', '展開');
            // 若所有子區塊都展開，則 indicator 也要變成 [全部收合]
            if (indicator) {
                const allUl = paperSection.querySelectorAll('.sub-content');
                const allOpen = Array.from(allUl).every(u => u.style.display !== 'none');
                indicator.textContent = allOpen ? '[全部收合]' : '[全部展開]';
            }
        } else {
            ul.style.display = 'none';
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
            btn.setAttribute('aria-label', '收合');
            // 只要有一個子區塊收合，indicator 就變成 [全部展開]
            if (indicator) {
                indicator.textContent = '[全部展開]';
            }
        }
    };
});

// 全部縮合
document.getElementById('collapseAllBtn').onclick = function() {
    document.querySelectorAll('.paper-section .paper-content').forEach(function(content) {
        content.style.display = 'none';
    });
    document.querySelectorAll('.paper-section .toggle-indicator').forEach(function(ind) {
        ind.textContent = '[全部展開]';
    });
    document.querySelectorAll('.toggle-sub-btn').forEach(function(btn) {
        btn.setAttribute('aria-label', '收合');
        const icon = btn.querySelector('i');
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
        const ul = btn.parentElement.nextElementSibling;
        ul.style.display = 'none';
    });
};
// 全部展開
document.getElementById('expandAllBtn').onclick = function() {
    document.querySelectorAll('.paper-section .paper-content').forEach(function(content) {
        content.style.display = '';
    });
    document.querySelectorAll('.paper-section .toggle-indicator').forEach(function(ind) {
        ind.textContent = '[全部收合]';
    });
    document.querySelectorAll('.toggle-sub-btn').forEach(function(btn) {
        btn.setAttribute('aria-label', '展開');
        const icon = btn.querySelector('i');
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
        const ul = btn.parentElement.nextElementSibling;
        ul.style.display = 'block';
    });
};


// 修正：移除 block-title 的 onclick 事件，避免整行都能展開/收合
// 請確保 <div class="block-title"> 沒有 onclick="togglePaperContent(this)"，只保留 span.toggle-indicator 的點擊功能
</script>
</body>
</html>

<?php
// 關閉連線
mysqli_close($link);
?>
