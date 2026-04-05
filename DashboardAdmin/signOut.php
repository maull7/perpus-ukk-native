<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();
header("Location: ../sign/index.php?logout=1");
exit;
