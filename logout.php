<?php
// logout.php
session_start();
session_unset();
session_destroy();

header("Location: index576.php");
exit;
?>
