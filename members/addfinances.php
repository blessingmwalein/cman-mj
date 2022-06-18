<?php
require_once '../packages/Paynow-PHP-SDK-master/autoloader.php';

// use Paynow\Payments\Paynow;
use Paynow\Payments\Paynow;

?>

<div class="row-fluid">
    <!-- block -->
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left"><i class="icon-plus-sign icon-large"> Add New Finance</i></div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <!--------------------form------------------->
                <form method="post">
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                <input class="input focused" name="name" id="focusedInput" type="text" placeholder="Name" required>
                            </p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                <input class="input focused" name="amount" id="focusedInput" type="text" placeholder="Amount" required>
                            </p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                <textarea name="description" class="form-control" id="" cols="" rows="3"></textarea>
                            </p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                <?php



                                $finance_types_q = mysqli_query($conn, "select * from finance_type where type='income'") or die(mysqli_error());
                                ?>
                                <select class="input focused" name="finance_type_id" id="focusedInput" required="required" type="text">
                                    <option value="">Select type</option>
                                    <?php while ($row = mysqli_fetch_array($finance_types_q)) { ?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                <?php $currencies_q = mysqli_query($conn, "select * from currencies where code='RTGS'") or die(mysqli_error());
                                ?>
                                <select class="input focused" name="currency_code" id="focusedInput" required="required" type="text">
                                    <option value="">Select currency</option>
                                    <?php while ($row = mysqli_fetch_array($currencies_q)) { ?>
                                        <option value="<?php echo $row['code'] ?>"><?php echo $row['code'] ?></option>
                                    <?php } ?>
                                </select>
                            </p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                <?php $members_query = mysqli_query($conn, "select * from members") or die(mysqli_error());
                                ?>
                                <input type="hidden" name="member_id" value="<?php echo  $user_row['keyu'] ?>">

                            </p>
                        </div>
                    </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button name="save" class="btn btn-info" id="save" data-placement="right" title="Click to Save"><i class="icon-plus-sign icon-large"> Save</i></button>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#save').tooltip('show');
                            $('#save').tooltip('hide');
                        });
                    </script>
                </div>
            </div>
            </form>

        </div>
    </div>
</div>
<!-- /block -->

<?php

$userQuery = mysqli_query($conn, "select * from members where id = '$session_id'") or die(mysqli_error());
$userRow = mysqli_fetch_array($query);

$paynow = new Paynow(
    '9278',
    'f0418000-b66b-47a7-bee3-f26831d66877',
    'http://localhost:8080/bling/cman-mj/members/finances.php',

    // The return url can be set at later stages. You might want to do this if you want to pass data to the return url (like the reference of the transaction)
    'http://localhost:8080/bling/cman-mj/members/finances.php'
);




if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $finance_type_id = $_POST['finance_type_id'];
    $member_id = $_POST['member_id'];
    $currency_code = $_POST['currency_code'];
    $amount = $_POST['amount'];


    $payment = $paynow->createPayment($_POST['description'], $userRow['email']);
    $payment->add($_POST['description'],  $amount);

    // Save the response from paynow in a variable
    $response = $paynow->send($payment);

    if ($response->success()) {
        // Redirect the user to Paynow

        // print_r($response);
        $paynow->setReturnUrl('http://localhost:8080/bling/cman-mj/members/finances.php');
        $redirectLink = $response->redirectUrl();
        $pollUrl = $response->pollUrl();
        mysqli_query($conn, "insert into finance (name, description, finance_type_id,member_id,currency_code,amount,status,pollurl) 
        values('$name','$description','$finance_type_id', '$member_id','$currency_code','$amount', 'pending','$pollUrl')") or die(mysqli_error());

        mysqli_query($conn, "insert into activity_log (date,username,action) values(NOW(),'','Added finance')") or die(mysqli_error());


?>
        <input type="text" id="redirect" value=" <?php echo $redirectLink ?>">

        <script type="text/javascript">
            location.href = document.getElementById('redirect').value
        </script>
    <?php
        // echo $redirectLink;


        // // Or if you prefer more control, get the link to redirect the user to, then use it as you see fit
        // $link = $response->redirectLink();

        // echo $link;
        // Get the poll url (used to check the status of a transaction). You might want to save this in your DB
    }




    ?>
    <script>
        window.location = "finances.php";
        $.jGrowl("Finance successfully added", {
            header: 'Finance add'
        });
    </script>
<?php

}
?>