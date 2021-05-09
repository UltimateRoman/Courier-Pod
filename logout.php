<?php
session_start();
session_destroy();
?>
<link href="css/styles.css" rel="stylesheet"/>
<h1>Courier-Pod</h1>
<h2>Courier Management System</h2>
<?php
echo "<br><br><p id='logout'>You've been sucessfully logged out<br><br>";
echo "<a href='/courierpod/login.php'>Click</a> to return</p>";
?>