<?php
    include "dbconfig.php";

    session_start();
    $msg = "";

    if($_SESSION['uname']) {
        if(isset($_POST['search'])) {
            $shipmentid = $_POST['shipmentid'];
            $qresp = mysqli_query($dbconn, "select * from consignments where shipmentid='$shipmentid'");
            $rcount = mysqli_num_rows($qresp);
            if($rcount) {
                $msg = "Shipment found";
            }
        }
        else {
            $qresp = mysqli_query($dbconn, "select * from consignments");
        }
?>

<html>

<h1 style="text-align: center">Courier-Pod</h1>
<h2 style="text-align: center">Courier Managment System</h2>

<?php
    echo "<p style='font-size: 20px'>Welcome, ".$_SESSION['uname']."<br>".$_SESSION['utype']."</p>";
?>

<p style="font-size:20px"><a href='/courierpod/createshipment.php'>Create shipment</a> &nbsp;&nbsp;
<a href='/courierpod/updateshipment.php'>Update shipment</a> &nbsp;&nbsp;
<?php
    if($_SESSION['utype']=='manager') {
        echo "<a href='/courierpod/register.php'>Register new Employee</a> &nbsp;&nbsp;";
    }
?>
<a href='/courierpod/logout.php'>Logout</a></p>
<p>

<h2 style="text-align: center">Available Shipments</h2>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <table>
        <tr>
            <td style="font-size: 20px">Enter Shipment ID</td>
            <td><input type="text" name="shipmentid" required/></td>
            <td><input type="submit" name="search" value="Search"/></td>
        </tr>
    </table>
</form>
<br>
<?php
    if($msg) {
        echo "<b>$msg</b>";
    }
?>
<p>
<table border="1" width="100%">
    <tr>
        <th>Shipment ID</th>
        <th>Shipper Details</th>
        <th>Consignee Detils</th>
        <th>Booked on</th>
        <th>(Est)/Delivery on</th>
        <th>Current Status</th>
        <th>Category</th>
        <th>Package details</th>
        <th>Charges</th>
        <th>Prepaid</th>
        <th>Contact</th>
    </tr>

<?php
    $rcount = mysqli_num_rows($qresp);

    if(!$rcount) {
        echo "<b>No shipments were found</b><br><br>";
    }

    else {
        while($row = mysqli_fetch_array($qresp)) {
            echo "
            <tr>
                <td>".$row['shipmentid']."</td>
                <td>".$row['from_name'].", ".$row['from_addr']."</td>
                <td>".$row['to_name'].", ".$row['to_addr']."</td>
                <td>".$row['booked_date']."</td>
                <td>".$row['est_deliverydate']."</td>
                <td>".$row['current_status']."</td>
                <td>".$row['category']."</td>
                <td>".$row['package_details']."</td>
                <td> Rs.".$row['amount']."</td>";
                if($row['prepaid']) {
                    echo "<td>Yes</td>";
                }
                else {
                    echo "<td>No</td>";
                }
            echo "
                <td>".$row['contact']."</td>
            </tr>
            ";
        }
    }

?>
    

</table>

</html>

<?php
    }
    else {
        header("Location: /courierpod/login.php");
    }
?>