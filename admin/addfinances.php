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
                                <?php $finance_types_q = mysqli_query($conn, "select * from finance_type") or die(mysqli_error());
                                            ?>
                                <select class="input focused" name="finance_type_id" id="focusedInput" required="required" type="text">
                                    <option value="">Select type</option>
                                    <?php  while ($row = mysqli_fetch_array($finance_types_q)){ ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                    <?php }?>
                                </select>
                            </p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                <?php $currencies_q = mysqli_query($conn, "select * from currencies") or die(mysqli_error());
                                            ?>
                                <select class="input focused" name="currency_code" id="focusedInput" required="required" type="text">
                                    <option value="">Select currency</option>
                                    <?php  while ($row = mysqli_fetch_array($currencies_q)){ ?>
                                    <option value="<?php echo $row['code'] ?>"><?php echo $row['code'] ?></option>
                                    <?php }?>
                                </select>
                            </p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                <?php $members_query = mysqli_query($conn, "select * from members") or die(mysqli_error());
                                            ?>
                                <select class="input focused" name="member_id" id="focusedInput" required="required" type="text">
                                    <option value="">Select member</option>
                                    <?php  while ($row = mysqli_fetch_array($members_query)){ ?>
                                    <option value="<?php echo $row['keyu'] ?>"><?php echo $row['fname'] . $row['sname'] ?></option>
                                    <?php }?>
                                </select>
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
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $finance_type_id = $_POST['finance_type_id'];
    $member_id = $_POST['member_id'];
    $currency_code = $_POST['currency_code'];
    $amount = $_POST['amount'];

    mysqli_query($conn, "insert into finance (name, description, finance_type_id,member_id,currency_code,amount) 
values('$name','$description','$finance_type_id', '$member_id','$currency_code','$amount')") or die(mysqli_error());

    mysqli_query($conn, "insert into activity_log (date,username,action) values(NOW(),'','Added finance')") or die(mysqli_error());
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