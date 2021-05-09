<?php
include "dbconfig.php";

$err_msg = "";
session_start();
session_destroy();

if(isset($_POST['login'])) {
    session_start();

    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);

    $qresp = mysqli_query($dbconn, "select * from admin where username='$username' and password=md5('$password')");

    $qrows = mysqli_num_rows($qresp);

    if($qrows) {
        $row = mysqli_fetch_array($qresp);

        $_SESSION['uname'] = $row['username'];
        $_SESSION['utype'] = $row['type'];
        header("Location: /courierpod/home.php");
    }
    else {
        $err_msg = "Incorrect credentials. Please try again.";
    }
}
?>

<html>
<link href="css/styles.css" rel="stylesheet"/>
<h1>Courier-Pod</h1>
<h2>Courier Managment System</h2>
<h3>Employee Login</h3>
<p>

<p id="links">
    <a href="/courierpod/index.html">Home-Page</a>&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="/courierpod/trackpackage.php">Track shipments</a>
</p>

<?php
    if($err_msg) {
        echo "<p>$err_msg</p>";
    }
?>
<br><br>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">

    <table>
        <tr>
            <td>Username</td>
            <td><input type="text" name="username" required/></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="password" required/></td>
        </tr>
    </table>
    <br><br>
    <div class="button">
        <input type="submit" name="login" value="Login"/>
    </div>
</form>
</html>