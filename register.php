<?php
include "dbconfig.php";
session_start();
if($_SESSION['uname']) {
    if($_SESSION['utype']!='manager') {
        header("Location: /courierpod/home.php");
    }

    else {
        if(isset($_POST['register'])) {
            if($_POST['password']==$_POST['rpassword']) {
                $unm = $_POST['username'];
                $pwd = md5($_POST['password']);
                $type = $_POST['type'];
                $query = "insert into admin(username, password, type) values('$unm', '$pwd', '$type')";
                mysqli_query($dbconn, $query);
                echo "Successfully registered";
            }
            else {
                echo "Passwords dont match";
            }
        }

        else {
?>
<html>
<h1 style="text-align: center">Courier-Pod</h1>
<h2 style="text-align: center">Register Employees</h2>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">

    <table>
        <tr>
            <td>Username</td>
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
            <td>Password</td>
            <td><input type="password" name="password" required/></td>
        </tr>
        <tr>
            <td>Retype Password</td>
            <td><input type="password" name="rpassword" required/></td>
        </tr>
    </table>

    <input type="submit" name="register" value="Register"/>
</form>
</html>
<?php 
        }
    }
}
else {
    header("Location: /courierpod/login.php");
}
?>