<?php
session_start();
session_destroy();
header("Location: /courierpod/login.php");
?>