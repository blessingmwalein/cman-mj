<div class="row-fluid">
    <a href="finance_types.php" class="btn btn-info" id="add" data-placement="right" title="Click to Add New"><i class="icon-plus-sign icon-large"></i>Add Finance Type</a>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#add').tooltip('show');
            $('#add').tooltip('hide');
        });
    </script>
    <!-- block -->
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left"><i class="icon-pencil icon-large"></i> Edit finance type.</div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <?php
                $query = mysqli_query($conn, "select * from finance_type where id = '$get_finance_id'") or die(mysqli_error());
                $row = mysqli_fetch_array($query);
                ?>

                <!-- --------------------form ---------------------->
                <form method="post">
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                <input value="<?php echo $row["name"] ?>" class="input focused" name="name" id="focusedInput" type="text" placeholder="Name" required>
                            </p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                <textarea name="description" class="form-control" id="" cols="" rows="3"><?php echo $row["description"] ?></textarea>
                            </p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                <select value="<?php echo $row["type"] ?>" class="input focused" name="type" id="focusedInput" required="required" type="text">
                                    <option value="">Select type</option>
                                    <option value="income">Income</option>
                                    <option value="expense">Expense</option>
                                </select>
                            </p>
                        </div>
                    </div>
                </form>
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

    $name = $_POST['name'];
    $description = $_POST['description'];
    $type = $_POST['type'];

    mysqli_query($conn, "UPDATE finance_type SET name = '$name', description ='$description',type = '$type' where id='$get_finance_id'")
        or die(mysqli_error());

    mysqli_query($conn, "insert into activity_log (date,username,action)
 values(NOW(),'$admin_username','Edited finance type $code')") or die(mysqli_error());
?>
    <script>
        window.location = "finance_types.php";
        $.jGrowl("Finance type Successfully Update", {
            header: 'Fiance type Update'
        });
    </script>
<?php
}
?>