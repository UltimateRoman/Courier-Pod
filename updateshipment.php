<?php

include "dbconfig.php";
session_start();
$msg = "";

if($_SESSION['uname']) {
    if(isset($_POST['delete'])) {
        $shipmentid = $_POST['shipmentid'];

        $qresp = mysqli_query($dbconn, "select * from consignments where shipmentid='$shipmentid'");

        $rcount = mysqli_num_rows($qresp);

        if(!$rcount) {
            $msg = "Shipment not found. Please try again.";
        }

        else {
            $query = "delete from consignments where shipmentid='$shipmentid'";
            $query1 = "delete from events where sid='$shipmentid'";

            mysqli_query($dbconn, $query) or die(mysqli_error());
            mysqli_query($dbconn, $query1) or die(mysqli_error());

            $msg = "Successfully deleted shipment";
        }
    }

    else if(isset($_POST['update'])) {
        $shipmentid = $_POST['shipmentid'];
        $status = $_POST['status'];
        $location = $_POST['location'];

        $qresp = mysqli_query($dbconn, "select * from consignments where shipmentid='$shipmentid'");

        $rcount = mysqli_num_rows($qresp);

        if(!$rcount) {
            $msg = "Shipment not found. Please try again.";
        }

        else {
            $query = "update consignments set current_status='$status' where shipmentid='$shipmentid'";
            $query1 = "insert into events values('$shipmentid', '$status', '$location', now())";

            mysqli_query($dbconn, $query) or die(mysqli_error());
            mysqli_query($dbconn, $query1) or die(mysqli_error());

            $msg = "Successfully updated shipment status";
        }
    }
?>

<html>
<h1 style="text-align: center">Courier-Pod</h1>
<h2 style="text-align: center">Courier Managment System</h2>
<h2 style="text-align: center">Update Shipments</h2>

<p style="font-size:20px"><a href='/courierpod/home.php'>Home</a> &nbsp;&nbsp;
<a href='/courierpod/createshipment.php'>Create shipment</a> &nbsp;&nbsp;
<a href='/courierpod/logout.php'>Logout</a></p>
<p>

<?php
    if($msg) {
        echo "<b>$msg</b>";
    }
?>
<p>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">

    <table>
        <tr>
            <td>Enter Shipment ID  </td>
            <td><input type="text" name="shipmentid" required/></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><input type="submit" name="delete" value="Delete Shipment"/></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Choose Updated Status &nbsp;&nbsp;</td>
            <td>
                <select name="status">
                    <option value="Picked Up">Picked Up</option>
                    <option value="Ready to Ship">Ready to Ship</option>
                    <option value="In Transit">In Transit</option>
                    <option value="Awaiting Customs Clearance">Awaiting Customs Clearance</option>
                    <option value="Out for Delivery">Out for Delivery</option>
                    <option value="Delivery Exception">Delivery Exception</option>
                    <option value="Delivered">Delivered</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Location </td>
            <td><input type="text" name="location"/></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>

    <input type="submit" name="update" value="Update Status"/>
</form>

</html>

<?php
}
else {
    header("Location: /courierpod/login.php");
}
?>