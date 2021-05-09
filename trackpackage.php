<?php
include "dbconfig.php";
?>

<html>
<link href="css/styles.css" rel="stylesheet"/>
<h1>Courier-Pod</h1>
<h2>Courier Managment System</h2>
<h3>Track Shipments</h3>

<p id="links"><a href='/courierpod/index.html'>Home-Page</a> &nbsp;&nbsp;
<p>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <table>
        <tr>
            <td>Enter Shipment ID (Tracking No) &nbsp;</td>
            <td><input type="text" name="shipmentid" required/>&nbsp;</td>
            <td><input type="submit" name="track" value="Track Shipment"/></td>
        </tr>
    </table>
</form>

<?php
    if(isset($_POST['track'])) {
        $shipmentid = strip_tags($_POST['shipmentid']);

        $qresp = mysqli_query($dbconn, "select * from consignments where shipmentid='$shipmentid'") or die(mysqli_error());

        $qresp1 = mysqli_query($dbconn, "select * from events where sid='$shipmentid' order by event_time desc") or die(mysqli_error());

        $rcount = mysqli_num_rows($qresp);

        if($rcount) {            
            $row = mysqli_fetch_array($qresp);
            $r1 = mysqli_fetch_array($qresp1);
            $loc = $r1['location'];

            echo "<h2 style='color: crimson'>Shipment ID: ".$row['shipmentid']."</h2>";
            echo "<p id='links'>Destination: ".$row['to_addr']."</p>";
            echo "<h2>Current Status: ".$row['current_status']." - $loc</h2>";
            echo "<h3>(Est)/Delivery On: ".$row['est_deliverydate']."</h3>";
            echo "<h3>Booked On: ".$row['booked_date']."</h3>";
            echo "<h3 style='color: darkmagenta'>History</h3>";
        ?>

        <table border="1">
            <tr>
                <th>Event</th>
                <th>Location</th>
                <th>Timestamp</th>
            </tr>
        <?php
            foreach($qresp1 as $rw) {
                echo "
                <tr>
                    <td>".$rw['status']."</td>
                    <td>".$rw['location']."</td>
                    <td>".$rw['event_time']."</td>
                </tr>
                ";
            }
        }

        else {
            echo "<b>Shipment not found. Please try again.</b>";
        }
    }
?>

</html>