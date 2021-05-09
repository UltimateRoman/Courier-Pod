<?php
session_start();
session_destroy();
echo "<p style='font-size: 25px'>You've been sucessfully logged out<br><br>";
echo "<a href='/courierpod/login.php'>Click</a> to return</p>";
?>