<?php
require_once '../packages/Paynow-PHP-SDK-master/autoloader.php';

// use Paynow\Payments\Paynow;
use Paynow\Payments\Paynow;

include('lib/dbcon.php');
dbcon();
$paynow = new Paynow(
    '9278',
    'f0418000-b66b-47a7-bee3-f26831d66877',
    'http://localhost:8080/bling/cman-mj/members/finances.php',

    // The return url can be set at later stages. You might want to do this if you want to pass data to the return url (like the reference of the transaction)
    'http://localhost:8080/bling/cman-mj/members/finances.php'
);

$finances_query = mysqli_query($conn, "select * from finance") or die(mysqli_error());
while ($row = mysqli_fetch_array($finances_query)) {
    if ($row['pollurl']) {
        $status = $paynow->pollTransaction($row['pollurl']);
        $id = $row['id'];
        $statusValue = $status->status() == "awaiting delivery" ? "paid" : "cancelled";

        print_r($status->status() . "-------------");

        mysqli_query($conn, "UPDATE finance SET status = '$statusValue' where id = '$id'")
            or die(mysqli_error());
    }
}

?>

<script>
    window.location = "finances.php";
</script>