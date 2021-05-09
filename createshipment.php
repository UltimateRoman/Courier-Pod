<?php
include "dbconfig.php";

session_start();
$msg = "";

if($_SESSION['uname']) {
    if(isset($_POST['create'])) {
        $shipmentid = uniqid();
        $from_name = $_POST['from_name'];
        $from_addr = $_POST['from_addr'];
        $to_name = $_POST['to_name'];
        $to_addr = $_POST['to_addr'];
        $est_deliverydate = $_POST['est_deliverydate'];
        $current_status = "Booked";
        $category = $_POST['category'];
        $package_details = $_POST['package_details'];
        $amount = $_POST['amount'];
        $prepaid = $_POST['prepaid'];
        $contact = $_POST['contact'];

        $query = "insert into consignments(shipmentid, from_name, from_addr, to_name, to_addr, booked_date, est_deliverydate, current_status, category, package_details, amount, prepaid, contact) values('$shipmentid', '$from_name', '$from_addr', '$to_name', '$to_addr', current_date, '$est_deliverydate', '$current_status', '$category', '$package_details', '$amount', '$prepaid', '$contact')";

        $query1 = "insert into events(sid, status, event_time) values('$shipmentid', '$current_status', now())";

        mysqli_query($dbconn, $query) or die(mysqli_error());
        mysqli_query($dbconn, $query1) or die(mysqli_error());

        $msg = "Successfully created new shipment, Shipment ID: ".$shipmentid;
    }

?>

<html>
<h1 style="text-align: center">Courier-Pod</h1>
<h2 style="text-align: center">Create a new Shipment</h2>

<?php
    if($msg) {
        echo "<b>$msg</b>";
    }
?>
<p>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">

    <table>
        <tr>
            <td>Shipper Name</td>
            <td><input type="text" name="from_name" required/></td>
        </tr>
        <tr>
            <td>Sender Address</td>
            <td><textarea name="from_addr" rows="4" cols="40" required></textarea></td>
        </tr>
        <tr>
            <td>Consignee Name</td>
            <td><input type="text" name="to_name" required/></td>
        </tr>
        <tr>
            <td>Destination Address</td>
            <td><textarea name="to_addr" rows="4" cols="40" required></textarea></td>
        </tr>
        <tr>
            <td>Category</td>
            <td>
                <select name="category">
                    <option value="Domestic-Standard">Domestic-Standard</option>
                    <option value="International-Express">International-Express</option>
                    <option value="International-Priority">International-Priority</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Estimated delivery date</td>
            <td><input type="text" name="est_deliverydate" required/></td>
        </tr>
        <tr>
            <td>Package details</td>
            <td><input type="text" name="package_details" required/></td>
        </tr>
        <tr>
            <td>Shipping charges (Rs.)</td>
            <td><input type="number" name="amount" required/></td>
        </tr>
        <tr>
            <td>Amount paid in advance?</td>
            <td>
                <input type="radio" name="prepaid" value="1" checked="checked"/>
                <label>Yes</label><br>
                <input type="radio" name="prepaid" value="0"/>
                <label>No</label>
            </td>
            <td>
                
            </td>
        </tr>
        <tr>
            <td>Contact</td>
            <td><input type="text" name="contact" required/></td>
        </tr>
    </table>

    <input type="submit" name="create" value="Create"/>
</form>


</html>

<?php
}
else {
    header("Location: /courierpod/login.php");
}
?>