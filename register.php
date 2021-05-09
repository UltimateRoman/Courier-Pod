<?php
include "dbconfig.php";

$msg = "";

session_start();
if($_SESSION['uname']) {
    if($_SESSION['utype']!='manager') {
        header("Location: /courierpod/home.php");
    }

    else {
        if(isset($_POST['register'])) {
            if(strlen($_POST['username']) > 20) {
                $msg = "Username is too long, maximum 20 characters allowed.";
            }

            else if(strlen($_POST['password']) < 8 || strlen($_POST['password']) > 20) {
                $msg = "Password must contain 8-20 characters.";
            }

            else if($_POST['password']!=$_POST['rpassword']) {
                $msg = "Passwords do not match.";
            }

            else {
                $unm = strip_tags($_POST['username']);
                $pwd = md5(strip_tags($_POST['password']));
                $type = strip_tags($_POST['type']);

                $qresp = mysqli_query($dbconn, "select * from admin where lower(username)=lower('$unm')") or die(mysqli_error());
                $rcount = mysqli_num_rows($qresp);

                if($rcount) {
                    $msg = "Username already exists.";
                }

                else {
                    $query = "insert into admin(username, password, type) values('$unm', '$pwd', '$type')";
                    mysqli_query($dbconn, $query) or die(mysqli_error());
                    $msg = "Successfully registered.";
                }
            }
        }
?>
<html>
<link href="css/styles.css" rel="stylesheet"/>
<h1>Courier-Pod</h1>
<h2>Courier Management System</h2>
<h3>Register Employees</h3>

<p id="links"><a href='/courierpod/home.php'>Home</a> &nbsp;&nbsp;
<a href='/courierpod/logout.php'>Logout</a></p>
<p>

<?php
    if($msg) {
        echo "<b>$msg</b>";
    }
?>
<p>

<br><br>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">

    <table>
        <tr>
            <td>Enter a Username</td>
            <td><input type="text" name="username" required/></td>
        </tr>
        <tr>
            <td>Type</td>
            <td>
                <select name="type">
                    <option value="employee">Employee</option>
                    <option value="manager">Manager</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Enter a Password</td>
            <td><input type="password" name="password" required/></td>
        </tr>
        <tr>
            <td>Retype the Password</td>
            <td><input type="password" name="rpassword" required/></td>
        </tr>
    </table>
    <br><br><br><br>
    <div class="button">
        <input type="submit" name="register" value="Register"/>
    </div>
</form>
</html>
<?php
    }
}
else {
    header("Location: /courierpod/login.php");
}
?>