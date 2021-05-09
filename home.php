<?php
    include "dbconfig.php";

    session_start();
    if($_SESSION['uname']) {
        $qresp = mysqli_query($dbconn, "select * from consignments");

?>

<html>
<h1 style="text-align: center">Courier-Pod</h1>
<h2 style="text-align: center">Courier Managment System</h2>

<?php
    echo "<p style='font-size: 20px'>Welcome, ".$_SESSION['uname']."<br>".$_SESSION['utype']."</p>";
?>

<p style="font-size:20px"><a href='/courierpod/createshipment.php'>Create shipment</a> &nbsp;&nbsp;
<a href='/courierpod/updateshipment.php'>Update shipment</a> &nbsp;&nbsp;
<a href='/courierpod/logout.php'>Logout</a></p>
<p>

<h2 style="text-align: center">Available Shipments</h2>

<table border="1" width="100%">
    <tr>
        <th>Shipment ID</th>
        <th>Shipper Name</th>
        <th>Consignee Name</th>
        <th>Current Status</th>
        <th>Category</th>
        <th>Contact</th>
    </tr>

<?php
    $rcount = mysqli_num_rows($qresp);

    if(!$rcount) {
        echo "<b>No shipments currently available</b>";
    }

    else {
        while($row = mysqli_fetch_array($qresp)) {
            echo "
            <tr>
                <td>".$row['shipmentid']."</td>
                <td>".$row['from_name']."</td>
                <td>".$row['to_name']."</td>
                <td>".$row['current_status']."</td>
                <td>".$row['category']."</td>
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