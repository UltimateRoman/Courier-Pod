<?php
session_start();
session_destroy();
echo "You've been logged out";
echo "<a href='/courierpod/login.php'>Click</a> to return";
?>