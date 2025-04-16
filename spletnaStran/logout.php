<?php
session_start();
session_unset();
session_destroy();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");

header("Location: login.php");
exit();
?>


