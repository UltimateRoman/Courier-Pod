<?php
include "dbconfig.php";
?>

<html>
<h1 style="text-align: center">Courier-Pod</h1>
<h2 style="text-align: center">Track Shipments</h2>

<p style="font-size:20px"><a href='/courierpod/index.html'>Home-Page</a> &nbsp;&nbsp;
<p>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <table>
        <tr>
            <td style="font-size: 20px">Enter Shipment ID (Tracking No) &nbsp;</td>
            <td><input type="text" name="shipmentid" required/>&nbsp;</td>
            <td><input type="submit" name="track" value="Track Shipment"/></td>
        </tr>
    </table>
</form>

<?php
    if(isset($_POST['track'])) {
        $shipmentid = $_POST['shipmentid'];

        $qresp = mysqli_query($dbconn, "select * from consignments where shipmentid='$shipmentid'") or die(mysqli_error());

        $qresp1 = mysqli_query($dbconn, "select * from events where sid='$shipmentid' order by event_time desc") or die(mysqli_error());

        $rcount = mysqli_num_rows($qresp);

        if($rcount) {            
            $row = mysqli_fetch_array($qresp);
            $r1 = mysqli_fetch_array($qresp1);
            $loc = $r1['location'];

            echo "<h2>Shipment ID: ".$row['shipmentid']."</h2>";
            echo "<h2>Current Status: ".$row['current_status']." - $loc</h2>";
            echo "<h3>(Est)/Delivery On: ".$row['est_deliverydate']."</h3>";
            echo "<h3>Booked On: ".$row['booked_date']."</h3><br>";
            echo "<h3>History</h3><br>";
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