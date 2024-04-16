<?php
session_start();
session_unset();
session_destroy();

//回首頁
header("location: ../login.php?error=none");

?>