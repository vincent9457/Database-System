<?php
// ===== auth_check.php =====
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header('Location: login.php');
    exit;
}
$teacher_id = $_SESSION['teacher_id'];
?>
