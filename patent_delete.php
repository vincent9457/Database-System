<?php
session_start();
require_once 'phpdb.php';

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$number = $_GET['number'] ?? '';

$stmt = mysqli_prepare($link, "DELETE FROM Patent WHERE teacher_id = ? AND number = ?");
mysqli_stmt_bind_param($stmt, 'is', $teacher_id, $number);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: patent_list.php");
exit;
?>
