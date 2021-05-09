<?php
include "dbconfig.php";

$err_msg = "";
session_start();
session_destroy();

if(isset($_POST['login'])) {
    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];

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
<h1 style="text-align: center">Courier-Pod</h1>
<h2 style="text-align: center">Courier Managment System</h2>
<h3 style="text-align: center">Employee Login</h3>
<p>

<?php
    if($err_msg) {
        echo "<p>$err_msg</p>";
    }
?>

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

    <input type="submit" name="login" value="Login"/>
</form>
</html>