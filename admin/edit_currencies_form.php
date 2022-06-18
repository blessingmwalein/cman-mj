<div class="row-fluid">
    <a href="currencies.php" class="btn btn-info" id="add" data-placement="right" title="Click to Add New"><i class="icon-plus-sign icon-large"></i> Add New member</a>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#add').tooltip('show');
            $('#add').tooltip('hide');
        });
    </script>
    <!-- block -->
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left"><i class="icon-pencil icon-large"></i> Edit currency Info.</div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <?php
                $query = mysqli_query($conn, "select * from currencies where id = '$get_currency_id'") or die(mysqli_error());
                $row = mysqli_fetch_array($query);
                ?>

                <!-- --------------------form ---------------------->
                <form method="post">
                    <div class="control-group">
                        <p>
                        <div class="controls">
                            <p>
                                <input class="input focused" name="code" value="<?php echo $row['code']; ?>" id="focusedInput" type="text" placeholder="Currency Code" required>
                            </p>
                        </div>
                    </div>
                    </p>

            </div>



            <div class="control-group">
                <div class="controls">
                    <button name="update" class="btn btn-info" id="update" data-placement="right" title="Click to Update"><i class="icon-plus-sign icon-large"> Update</i></button>
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
if (isset($_POST['update'])) {
    $code = $_POST['code'];

    mysqli_query($conn, "UPDATE currencies SET code = '$code' where id='$get_currency_id'")
        or die(mysqli_error());

    mysqli_query($conn, "insert into activity_log (date,username,action)
 values(NOW(),'$admin_username','Edited currency $code')") or die(mysqli_error());
?>
    <script>
        window.location = "currencies.php";
        $.jGrowl("Currency Successfully Update", {
            header: 'Currency Update'
        });
    </script>
<?php
}
?>