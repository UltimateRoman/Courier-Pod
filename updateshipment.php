<?php

include "dbconfig.php";
session_start();

if($_SESSION['uname']) {
    if(isset($_POST['update'])) {

    }

    else if(isset($_POST['delete'])) {

    }
?>

<?php
}
else {
    header("Location: /courierpod/login.php");
}
?>