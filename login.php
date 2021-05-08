<?php
include "dbconfig.php";

if(isset($_POST['login'])) {
    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $qresp = mysqli_query($dbconn, "select * from admin where username='$username' and password=md5('$password')");

    $qrows = mysqli_num_rows($qresp);

    if($qrows) {
        $_SESSION['uname'] = $username;
        header("Location: /courierpod/home.php");
    }
    else {
        echo "Incorrect credentials. Please try again.";
    }
}

else {
?>
<html>
<h1 style="text-align: center">Courier-Pod</h1>
<h2 style="text-align: center">Admin Login</h2>

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
<?php
}
?>
