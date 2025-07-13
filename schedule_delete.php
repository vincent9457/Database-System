<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$weekday = $_GET['weekday'] ?? '';
$start_period = $_GET['start_period'] ?? 0;

if ($weekday && $start_period) {
    $sql = "DELETE FROM Schedule WHERE teacher_id = ? AND weekday = ? AND start_period = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 'isi', $teacher_id, $weekday, $start_period);
    mysqli_stmt_execute($stmt);
}

header("Location: dashboard.php");
exit;
