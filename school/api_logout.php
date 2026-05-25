<?php
session_start();
// 撕毀通行證
session_destroy();
// 彈回登入頁面
header("Location: login.php");
exit;
?>