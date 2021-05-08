<?php
    session_start();
    if($_SESSION['uname']) {
        echo "Hi ".$_SESSION['uname'];
        echo "<br>".$_SESSION['utype'];

        echo "<a href='/courierpod/logout.php'>Logout</a>";
    }
    else {
        header("Location: /courierpod/login.php");
    }
?>